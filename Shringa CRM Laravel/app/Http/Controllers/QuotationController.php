<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Client;
use App\Models\Lead;
use App\Models\CommunicationLog;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Quotation::with(['client', 'lead']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by scope type
        if ($request->filled('scope_type')) {
            $query->where('scope_type', $request->scope_type);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('quotation_number', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%")
                  ->orWhere('project_title', 'like', "%{$search}%")
                  ->orWhereHas('client', function ($clientQuery) use ($search) {
                      $clientQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Order by latest
        $quotations = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('quotations.index', compact('quotations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Quotation $quotation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quotation $quotation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quotation $quotation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quotation $quotation)
    {
        //
    }

    /**
     * Send quotation to client.
     */
    public function send(Request $request, Quotation $quotation)
    {
        // Validate inputs
        $validated = $request->validate([
            'recipient_email' => 'required|email',
            'recipient_name' => 'required|string',
            'message' => 'nullable|string',
            'send_method' => 'required|in:email,whatsapp',
        ]);
        
        $sendMethod = $validated['send_method'];
        $recipientEmail = $validated['recipient_email'];
        $recipientName = $validated['recipient_name'];
        $message = $validated['message'] ?? "Please find attached our quotation for your review.";
        
        // Generate share URL
        $shareUrl = route('quotations.public.view', ['token' => $quotation->share_link_token]);
        
        try {
            // Send email or WhatsApp based on selected method
            if ($sendMethod === 'email') {
                // Email sending logic would go here
                // For this example, we'll just log it
                Log::info("Quotation {$quotation->quotation_number} sent to {$recipientEmail} via email.");
            } else {
                // WhatsApp sending logic would go here
                // For this example, we'll just log it
                Log::info("Quotation {$quotation->quotation_number} sent to {$recipientName} via WhatsApp.");
            }
            
            // Update quotation status
            $quotation->status = 'sent';
            $quotation->sent_at = now();
            $quotation->save();
            
            // Create communication log entry
            CommunicationLog::create([
                'communication_type' => $sendMethod,
                'content' => "Quotation {$quotation->quotation_number} sent via {$sendMethod}.\n\nMessage: {$message}",
                'client_id' => $quotation->client_id,
                'lead_id' => $quotation->lead_id,
                'direction' => 'outgoing',
                'user_id' => Auth::id(),
                'status' => 'sent',
                'delivered_at' => now(),
            ]);
            
            return redirect()->route('quotations.show', $quotation)
                ->with('success', "Quotation sent successfully via {$sendMethod}");
        } catch (\Exception $e) {
            Log::error("Failed to send quotation: " . $e->getMessage());
            
            return redirect()->route('quotations.show', $quotation)
                ->with('error', "Failed to send quotation: " . $e->getMessage());
        }
    }
    
    /**
     * Download quotation as PDF.
     */
    public function download(Quotation $quotation)
    {
        // Load relationships
        $quotation->load(['client', 'lead', 'quotationItems']);
        
        // Get media collections
        $projectImages = $quotation->getMedia('project_images');
        
        // Generate PDF
        $pdf = PDF::loadView('quotations.pdf', compact('quotation', 'projectImages'));
        
        // Set PDF options
        $pdf->setPaper('a4');
        
        // Return PDF for download
        return $pdf->download("quotation-{$quotation->quotation_number}.pdf");
    }
    
    /**
     * Show public view of quotation via share link.
     */
    public function publicView(string $token)
    {
        // Find quotation by share link token
        $quotation = Quotation::where('share_link_token', $token)->first();
        
        // Check if quotation exists
        if (!$quotation) {
            abort(404, 'Quotation not found');
        }
        
        // Load relationships
        $quotation->load(['client', 'lead', 'quotationItems']);
        
        // Get media collections
        $projectImages = $quotation->getMedia('project_images');
        
        // Update viewed status if not already viewed
        if ($quotation->status === 'sent') {
            $quotation->status = 'viewed';
            $quotation->viewed_at = now();
        }
        
        // Always update last viewed time
        $quotation->last_viewed_by_client_at = now();
        $quotation->save();
        
        return view('quotations.public-view', compact('quotation', 'projectImages'));
    }
    
    /**
     * Update quotation status from public view.
     */
    public function updateStatus(Request $request, string $token)
    {
        // Validate inputs
        $validated = $request->validate([
            'status' => 'required|in:accepted,rejected',
            'feedback' => 'nullable|string',
        ]);
        
        // Find quotation by share link token
        $quotation = Quotation::where('share_link_token', $token)->first();
        
        // Check if quotation exists
        if (!$quotation) {
            abort(404, 'Quotation not found');
        }
        
        // Update status
        $quotation->status = $validated['status'];
        $quotation->save();
        
        // Create communication log entry
        CommunicationLog::create([
            'communication_type' => 'quotation_response',
            'content' => "Quotation {$quotation->quotation_number} was {$validated['status']}.\n\nFeedback: " . ($validated['feedback'] ?? 'None provided'),
            'client_id' => $quotation->client_id,
            'lead_id' => $quotation->lead_id,
            'direction' => 'incoming',
            'status' => 'received',
            'delivered_at' => now(),
        ]);
        
        return redirect()->route('quotations.public.view', ['token' => $token])
            ->with('success', "Thank you for your response. Your feedback has been recorded.");
    }
}
