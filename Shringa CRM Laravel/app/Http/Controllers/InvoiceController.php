<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Project;
use App\Models\Client;
use App\Models\Payment;
use App\Models\CommunicationLog;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\PDF;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Invoice::class, 'invoice');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // Get filter parameters
        $status = $request->input('status');
        $milestone_type = $request->input('milestone_type');
        $search = $request->input('search');
        
        // Base query
        $query = Invoice::query()->with(['client', 'project']);
        
        // Apply filters if provided
        if ($status) {
            $query->where('status', $status);
        }
        
        if ($milestone_type) {
            $query->where('milestone_type', $milestone_type);
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('client', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('company_name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('project', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Get paginated results
        $invoices = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Get milestone types and statuses for filters
        $milestoneTypes = Invoice::availableMilestoneTypes();
        $statuses = Invoice::availableStatuses();
        
        return view('invoices.index', compact('invoices', 'milestoneTypes', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get data for dropdowns
        $projects = Project::orderBy('name')->get();
        $clients = Client::orderBy('name')->get();
        $milestoneTypes = Invoice::availableMilestoneTypes();
        
        // Default GST percentage
        $defaultGst = 18.0; // 18% GST in India
        
        return view('invoices.create', compact('projects', 'clients', 'milestoneTypes', 'defaultGst'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'client_id' => 'required|exists:clients,id',
            'milestone_type' => 'required|string',
            'due_date' => 'required|date',
            'subtotal' => 'required|numeric|min:0',
            'gst_percentage' => 'required|numeric|min:0|max:28',
            'notes' => 'nullable|string',
            'items' => 'nullable|array',
            'items.*.description' => 'required|string',
            'items.*.amount' => 'required|numeric|min:0',
        ]);
        
        // Generate invoice number
        $invoiceNumber = Invoice::generateInvoiceNumber();
        
        // Calculate GST amount and total
        $gstAmount = ($validated['subtotal'] * $validated['gst_percentage']) / 100;
        $total = $validated['subtotal'] + $gstAmount;
        
        // Create invoice
        $invoice = Invoice::create([
            'invoice_number' => $invoiceNumber,
            'project_id' => $validated['project_id'],
            'client_id' => $validated['client_id'],
            'milestone_type' => $validated['milestone_type'],
            'due_date' => $validated['due_date'],
            'subtotal' => $validated['subtotal'],
            'gst_percentage' => $validated['gst_percentage'],
            'gst_amount' => $gstAmount,
            'total' => $total,
            'amount_paid' => 0,
            'amount_due' => $total,
            'status' => 'draft',
            'notes' => $validated['notes'],
        ]);
        
        // Store invoice items if provided
        if (isset($validated['items']) && !empty($validated['items'])) {
            $invoice->items = $validated['items'];
            $invoice->save();
        }
        
        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        // Load relationships
        $invoice->load(['client', 'project', 'payments']);
        
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        // Get data for dropdowns
        $projects = Project::orderBy('name')->get();
        $clients = Client::orderBy('name')->get();
        $milestoneTypes = Invoice::availableMilestoneTypes();
        $statuses = Invoice::availableStatuses();
        
        return view('invoices.edit', compact('invoice', 'projects', 'clients', 'milestoneTypes', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        // Only allow certain updates if the invoice is not paid
        if ($invoice->status === 'paid') {
            return redirect()->route('invoices.show', $invoice)
                ->with('error', 'Paid invoices cannot be modified');
        }
        
        // Validate the request
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'client_id' => 'required|exists:clients,id',
            'milestone_type' => 'required|string',
            'due_date' => 'required|date',
            'subtotal' => $invoice->status === 'draft' ? 'required|numeric|min:0' : 'prohibited',
            'gst_percentage' => $invoice->status === 'draft' ? 'required|numeric|min:0|max:28' : 'prohibited',
            'status' => 'required|string',
            'notes' => 'nullable|string',
            'items' => 'nullable|array',
            'items.*.description' => 'required|string',
            'items.*.amount' => 'required|numeric|min:0',
        ]);
        
        // Only recalculate totals if the invoice is in draft state
        if ($invoice->status === 'draft') {
            // Calculate GST amount and total
            $gstAmount = ($validated['subtotal'] * $validated['gst_percentage']) / 100;
            $total = $validated['subtotal'] + $gstAmount;
            
            $validated['gst_amount'] = $gstAmount;
            $validated['total'] = $total;
            $validated['amount_due'] = $total - $invoice->amount_paid;
        }
        
        // Update the invoice
        $invoice->update($validated);
        
        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        // Check if the invoice has payments
        if ($invoice->payments()->count() > 0) {
            return redirect()->route('invoices.index')
                ->with('error', 'Cannot delete invoice with associated payments');
        }
        
        $invoice->delete();
        
        return redirect()->route('invoices.index')
            ->with('success', 'Invoice deleted successfully');
    }
    
    /**
     * Send invoice to client.
     */
    public function send(Request $request, Invoice $invoice)
    {
        // Update invoice status to sent if it's a draft
        if ($invoice->status === 'draft') {
            $invoice->status = 'sent';
            $invoice->save();
        }
        
        // Validate the request
        $validated = $request->validate([
            'email' => 'required|email',
            'message' => 'nullable|string',
        ]);
        
        // In a real application, you would send an email to the client here
        // For now, just create a communication log entry
        
        CommunicationLog::create([
            'communication_type' => 'email',
            'content' => $validated['message'] ?? "Invoice {$invoice->invoice_number} has been sent.",
            'client_id' => $invoice->client_id,
            'project_id' => $invoice->project_id,
            'direction' => 'outgoing',
            'user_id' => Auth::id(),
            'status' => 'sent',
            'delivered_at' => now(),
        ]);
        
        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice sent to client');
    }
    
    /**
     * Download invoice as PDF.
     */
    public function download(Invoice $invoice)
    {
        // Load relationships
        $invoice->load(['client', 'project']);
        
        // Generate PDF
        $pdf = PDF::loadView('invoices.pdf', compact('invoice'));
        
        // Set PDF options
        $pdf->setPaper('a4');
        
        // Return PDF for download
        return $pdf->download("invoice-{$invoice->invoice_number}.pdf");
    }
    
    /**
     * Record payment for an invoice.
     */
    public function recordPayment(Request $request, Invoice $invoice)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string',
            'payment_date' => 'required|date',
            'transaction_id' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);
        
        // Create a payment record
        $payment = Payment::create([
            'payment_number' => Payment::generatePaymentNumber(),
            'invoice_id' => $invoice->id,
            'client_id' => $invoice->client_id,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'payment_status' => 'completed',
            'notes' => $request->notes,
            'received_by' => Auth::id(),
        ]);
        
        // Update the invoice amounts
        $invoice->amount_paid += $request->amount;
        $invoice->amount_due = $invoice->calculateAmountDue();
        
        // Update status
        if ($invoice->amount_due <= 0) {
            $invoice->status = 'paid';
            $invoice->paid_at = now();
        } else {
            $invoice->status = 'partially_paid';
        }
        
        $invoice->save();
        
        // Create communication log entry
        CommunicationLog::create([
            'communication_type' => 'payment',
            'content' => "Payment of {$request->amount} received for invoice {$invoice->invoice_number}",
            'client_id' => $invoice->client_id,
            'project_id' => $invoice->project_id,
            'direction' => 'incoming',
            'user_id' => Auth::id(),
            'status' => 'received',
            'delivered_at' => now(),
        ]);
        
        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Payment recorded successfully');
    }
    
    /**
     * Send reminder for overdue invoice
     */
    public function sendReminder(Invoice $invoice)
    {
        // Update reminder sent timestamp
        $invoice->reminder_sent_at = now();
        $invoice->save();
        
        // In a real application, you would send an email to the client here
        // For now, just create a communication log entry
        
        CommunicationLog::create([
            'communication_type' => 'email',
            'content' => "Reminder: Invoice {$invoice->invoice_number} is overdue. Please make the payment as soon as possible.",
            'client_id' => $invoice->client_id,
            'project_id' => $invoice->project_id,
            'direction' => 'outgoing',
            'user_id' => Auth::id(),
            'status' => 'sent',
            'delivered_at' => now(),
        ]);
        
        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Payment reminder sent to client');
    }
    
    /**
     * Display analytics dashboard for invoices
     */
    public function analytics()
    {
        // Get invoice amounts by status
        $statusAmounts = Invoice::selectRaw('status, SUM(total) as total_amount, COUNT(*) as count')
                        ->groupBy('status')
                        ->get();
                        
        // Get total amounts
        $totalInvoiced = Invoice::sum('total');
        $totalPaid = Invoice::sum('amount_paid');
        $totalOutstanding = Invoice::sum('amount_due');
        
        // Get overdue invoices
        $overdueInvoices = Invoice::where('status', '!=', 'paid')
                          ->where('due_date', '<', now())
                          ->orderBy('due_date')
                          ->get();
                          
        // Get payment methods distribution
        $paymentMethods = Payment::selectRaw('payment_method, SUM(amount) as total_amount, COUNT(*) as count')
                         ->groupBy('payment_method')
                         ->get();
                         
        return view('invoices.analytics', compact(
            'statusAmounts',
            'totalInvoiced',
            'totalPaid',
            'totalOutstanding',
            'overdueInvoices',
            'paymentMethods'
        ));
    }
}
