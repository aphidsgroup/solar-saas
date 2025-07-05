<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Client;
use App\Models\User;
use App\Models\CommunicationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\PDF;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Payment::class, 'payment');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $status = $request->input('status');
        $method = $request->input('method');
        $search = $request->input('search');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        
        // Base query
        $query = Payment::query()->with(['invoice', 'client', 'receivedBy']);
        
        // Apply filters if provided
        if ($status) {
            $query->where('payment_status', $status);
        }
        
        if ($method) {
            $query->where('payment_method', $method);
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('payment_number', 'like', "%{$search}%")
                  ->orWhere('transaction_id', 'like', "%{$search}%")
                  ->orWhereHas('client', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('company_name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('invoice', function($q) use ($search) {
                      $q->where('invoice_number', 'like', "%{$search}%");
                  });
            });
        }
        
        // Date range filter
        if ($dateFrom) {
            $query->whereDate('payment_date', '>=', $dateFrom);
        }
        
        if ($dateTo) {
            $query->whereDate('payment_date', '<=', $dateTo);
        }
        
        // Get paginated results
        $payments = $query->orderBy('payment_date', 'desc')->paginate(10);
        
        // Get payment methods and statuses for filters
        $methods = Payment::availablePaymentMethods();
        $statuses = Payment::availablePaymentStatuses();
        
        return view('payments.index', compact('payments', 'methods', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get data for dropdowns
        $invoices = Invoice::where('status', '!=', 'paid')
                    ->orderBy('due_date', 'asc')
                    ->get();
        $clients = Client::orderBy('name', 'asc')->get();
        $methods = Payment::availablePaymentMethods();
        $statuses = Payment::availablePaymentStatuses();
        
        return view('payments.create', compact('invoices', 'clients', 'methods', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'client_id' => 'required|exists:clients,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string|max:255',
            'payment_status' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        
        // Generate payment number
        $validated['payment_number'] = Payment::generatePaymentNumber();
        
        // Set received by to current user
        $validated['received_by'] = Auth::id();
        
        // Create the payment
        $payment = Payment::create($validated);
        
        // Update the associated invoice
        $invoice = Invoice::findOrFail($validated['invoice_id']);
        $invoice->amount_paid += $validated['amount'];
        $invoice->amount_due = $invoice->calculateAmountDue();
        
        // Update invoice status
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
            'content' => "Payment {$payment->payment_number} of {$validated['amount']} received via {$validated['payment_method']}",
            'client_id' => $validated['client_id'],
            'direction' => 'incoming',
            'user_id' => Auth::id(),
            'status' => 'received',
            'delivered_at' => now(),
        ]);
        
        // Generate receipt if payment is completed
        if ($validated['payment_status'] === 'completed') {
            $this->generateReceipt($payment);
        }
        
        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment recorded successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $payment->load(['invoice', 'client', 'receivedBy']);
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        $payment->load(['invoice', 'client', 'receivedBy']);
        
        // Get data for dropdowns
        $invoices = Invoice::orderBy('due_date', 'asc')->get();
        $clients = Client::orderBy('name', 'asc')->get();
        $methods = Payment::availablePaymentMethods();
        $statuses = Payment::availablePaymentStatuses();
        
        return view('payments.edit', compact('payment', 'invoices', 'clients', 'methods', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        // Validate the request
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'client_id' => 'required|exists:clients,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string|max:255',
            'payment_status' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        
        // Store old values to handle invoice updates
        $oldInvoiceId = $payment->invoice_id;
        $oldAmount = $payment->amount;
        
        // Update the payment
        $payment->update($validated);
        
        // Handle invoice updates if needed
        if ($oldInvoiceId != $validated['invoice_id'] || $oldAmount != $validated['amount']) {
            // Adjust old invoice
            if ($oldInvoiceId) {
                $oldInvoice = Invoice::find($oldInvoiceId);
                if ($oldInvoice) {
                    $oldInvoice->amount_paid -= $oldAmount;
                    $oldInvoice->amount_due = $oldInvoice->calculateAmountDue();
                    
                    // Update old invoice status
                    if ($oldInvoice->amount_paid <= 0) {
                        $oldInvoice->status = 'sent';
                        $oldInvoice->paid_at = null;
                    } else {
                        $oldInvoice->status = 'partially_paid';
                    }
                    
                    $oldInvoice->save();
                }
            }
            
            // Adjust new invoice
            $newInvoice = Invoice::find($validated['invoice_id']);
            $newInvoice->amount_paid += $validated['amount'];
            $newInvoice->amount_due = $newInvoice->calculateAmountDue();
            
            // Update new invoice status
            if ($newInvoice->amount_due <= 0) {
                $newInvoice->status = 'paid';
                $newInvoice->paid_at = now();
            } else {
                $newInvoice->status = 'partially_paid';
            }
            
            $newInvoice->save();
        }
        
        // Regenerate receipt if needed
        if ($payment->receipt_generated) {
            $this->generateReceipt($payment);
        }
        
        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        // Get the invoice to update after payment is deleted
        $invoice = $payment->invoice;
        $amount = $payment->amount;
        
        // Delete the payment
        $payment->delete();
        
        // Update the invoice
        if ($invoice) {
            $invoice->amount_paid -= $amount;
            $invoice->amount_due = $invoice->calculateAmountDue();
            
            // Update invoice status
            if ($invoice->amount_paid <= 0) {
                $invoice->status = 'sent';
                $invoice->paid_at = null;
            } else {
                $invoice->status = 'partially_paid';
            }
            
            $invoice->save();
        }
        
        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully');
    }
    
    /**
     * Generate receipt for a payment
     */
    public function generateReceipt(Payment $payment)
    {
        // Load relationships
        $payment->load(['invoice', 'client', 'receivedBy']);
        
        // Generate PDF
        $pdf = PDF::loadView('payments.receipt', compact('payment'));
        
        // Set PDF options
        $pdf->setPaper('a4');
        
        // Save the PDF to storage
        $filename = 'receipt-' . $payment->payment_number . '.pdf';
        $path = 'receipts/' . $filename;
        Storage::disk('public')->put($path, $pdf->output());
        
        // Add the receipt to media collection
        $payment->addMediaFromDisk($path, 'public')
                ->usingName('Receipt for Payment ' . $payment->payment_number)
                ->usingFileName($filename)
                ->toMediaCollection('payment_receipts');
        
        // Update payment to mark receipt as generated
        $payment->receipt_generated = true;
        $payment->save();
        
        return $pdf;
    }
    
    /**
     * Download receipt for a payment
     */
    public function downloadReceipt(Payment $payment)
    {
        // Check if receipt exists
        $receipt = $payment->getFirstMedia('payment_receipts');
        
        if ($receipt) {
            // Return existing receipt
            return response()->download($receipt->getPath(), 'receipt-' . $payment->payment_number . '.pdf');
        } else {
            // Generate receipt and download
            $pdf = $this->generateReceipt($payment);
            return $pdf->download('receipt-' . $payment->payment_number . '.pdf');
        }
    }
    
    /**
     * Send receipt to client
     */
    public function sendReceipt(Payment $payment)
    {
        // Check if receipt exists, generate if not
        if (!$payment->receipt_generated) {
            $this->generateReceipt($payment);
        }
        
        // In a real implementation, this would send the receipt via email
        // For now, just mark it as sent
        $payment->receipt_sent = true;
        $payment->save();
        
        // Create communication log entry
        CommunicationLog::create([
            'communication_type' => 'email',
            'content' => "Receipt for payment {$payment->payment_number} sent to client",
            'client_id' => $payment->client_id,
            'direction' => 'outgoing',
            'user_id' => Auth::id(),
            'status' => 'sent',
            'delivered_at' => now(),
        ]);
        
        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment receipt sent to client');
    }
}
