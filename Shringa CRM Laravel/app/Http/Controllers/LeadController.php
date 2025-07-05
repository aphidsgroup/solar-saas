<?php

namespace App\Http\Controllers;

use App\Jobs\SendLeadFollowUpReminder;
use App\Models\Client;
use App\Models\CommunicationLog;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Lead::class, 'lead');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $status = $request->input('status');
        $source = $request->input('source');
        $assignedTo = $request->input('assigned_to');
        $sourceDetail = $request->input('source_detail');
        $sourceCampaign = $request->input('source_campaign');
        
        // Base query
        $query = Lead::query()->with(['assignedUser']);
        
        // Apply filters if provided
        if ($status) {
            $query->where('status', $status);
        }
        
        if ($source) {
            $query->where('source', $source);
        }

        if ($sourceDetail) {
            $query->where('source_detail', $sourceDetail);
        }

        if ($sourceCampaign) {
            $query->where('source_campaign', $sourceCampaign);
        }
        
        if ($assignedTo) {
            $query->where('assigned_to', $assignedTo);
        }
        
        // Get current user
        $user = Auth::user();
        
        // If not admin, only show leads assigned to this user
        if (!$user->hasRole('admin')) {
            $query->where('assigned_to', $user->id);
        }
        
        // Get paginated results
        $leads = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Get users for assignment dropdown
        $users = User::all();
        
        // Get statuses and sources for filters
        $statuses = ['new', 'contacted', 'quoted', 'design_discussion', 'converted', 'lost'];
        $sources = ['Website', 'Social Media', 'Walk-in', 'Exhibition', 'Referral'];
        
        // Get source details for filter
        $sourceDetails = Lead::whereNotNull('source_detail')
            ->select('source_detail')
            ->distinct()
            ->pluck('source_detail')
            ->toArray();
            
        // Get source campaigns for filter
        $sourceCampaigns = Lead::whereNotNull('source_campaign')
            ->select('source_campaign')
            ->distinct()
            ->pluck('source_campaign')
            ->toArray();
        
        return view('leads.index', compact(
            'leads', 
            'users', 
            'statuses', 
            'sources', 
            'sourceDetails', 
            'sourceCampaigns'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get users for assignment dropdown
        $users = User::all();
        
        // Get sources for dropdown
        $sources = ['Website', 'Social Media', 'Walk-in', 'Exhibition', 'Referral'];
        
        // Get source details for dropdown
        $sourceDetails = Lead::whereNotNull('source_detail')
            ->select('source_detail')
            ->distinct()
            ->pluck('source_detail')
            ->toArray();
            
        // Get source campaigns for dropdown
        $sourceCampaigns = Lead::whereNotNull('source_campaign')
            ->select('source_campaign')
            ->distinct()
            ->pluck('source_campaign')
            ->toArray();
            
        return view('leads.create', compact('users', 'sources', 'sourceDetails', 'sourceCampaigns'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'source' => 'required|string|max:255',
            'source_detail' => 'nullable|string|max:255',
            'source_campaign' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'requirements' => 'nullable|string',
            'notes' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'follow_up_date' => 'nullable|date',
        ]);
        
        // Set default status
        $validated['status'] = 'new';
        
        // Create the lead
        $lead = Lead::create($validated);
        
        // If follow-up date is set, schedule a reminder
        if (isset($validated['follow_up_date']) && $validated['follow_up_date']) {
            SendLeadFollowUpReminder::dispatch($lead)
                ->delay(now()->diffInMinutes($validated['follow_up_date']) * 60);
        }
        
        return redirect()->route('leads.show', $lead)
            ->with('success', 'Lead created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        // Load relationships
        $lead->load(['assignedUser', 'client', 'quotations', 'siteVisits', 'communicationLogs']);
        
        // Get users for assignment dropdown
        $users = User::all();
        
        // Get statuses for dropdown
        $statuses = ['new', 'contacted', 'quoted', 'design_discussion', 'converted', 'lost'];
        
        return view('leads.show', compact('lead', 'users', 'statuses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        // Get users for assignment dropdown
        $users = User::all();
        
        // Get sources for dropdown
        $sources = ['Website', 'Social Media', 'Walk-in', 'Exhibition', 'Referral'];
        
        // Get source details for dropdown
        $sourceDetails = Lead::whereNotNull('source_detail')
            ->select('source_detail')
            ->distinct()
            ->pluck('source_detail')
            ->toArray();
            
        // Add the current lead's source detail if not in the list
        if ($lead->source_detail && !in_array($lead->source_detail, $sourceDetails)) {
            $sourceDetails[] = $lead->source_detail;
        }
            
        // Get source campaigns for dropdown
        $sourceCampaigns = Lead::whereNotNull('source_campaign')
            ->select('source_campaign')
            ->distinct()
            ->pluck('source_campaign')
            ->toArray();
            
        // Add the current lead's source campaign if not in the list
        if ($lead->source_campaign && !in_array($lead->source_campaign, $sourceCampaigns)) {
            $sourceCampaigns[] = $lead->source_campaign;
        }
        
        // Get statuses for dropdown
        $statuses = ['new', 'contacted', 'quoted', 'design_discussion', 'converted', 'lost'];
        
        return view('leads.edit', compact(
            'lead', 
            'users', 
            'sources', 
            'sourceDetails', 
            'sourceCampaigns', 
            'statuses'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'source' => 'required|string|max:255',
            'source_detail' => 'nullable|string|max:255',
            'source_campaign' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'address' => 'nullable|string',
            'requirements' => 'nullable|string',
            'notes' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'follow_up_date' => 'nullable|date',
        ]);
        
        // Save previous status to check for changes
        $previousStatus = $lead->status;
        $previousAssignedTo = $lead->assigned_to;
        
        // Update the lead
        $lead->update($validated);
        
        // Check if status has changed and take appropriate actions
        if ($previousStatus !== $validated['status']) {
            // If status changed to 'contacted', update last_contacted_at
            if ($validated['status'] === 'contacted') {
                $lead->last_contacted_at = now();
                $lead->save();
                
                // Create communication log entry
                CommunicationLog::create([
                    'communication_type' => 'status_update',
                    'content' => 'Lead status changed to Contacted',
                    'lead_id' => $lead->id,
                    'direction' => 'outgoing',
                    'user_id' => Auth::id(),
                    'status' => 'sent',
                    'delivered_at' => now(),
                ]);
            } elseif ($validated['status'] === 'quoted') {
                // Create communication log entry for quoted status
                CommunicationLog::create([
                    'communication_type' => 'status_update',
                    'content' => 'Lead status changed to Quoted',
                    'lead_id' => $lead->id,
                    'direction' => 'outgoing',
                    'user_id' => Auth::id(),
                    'status' => 'sent',
                    'delivered_at' => now(),
                ]);
            } elseif ($validated['status'] === 'design_discussion') {
                // Create communication log entry for design discussion status
                CommunicationLog::create([
                    'communication_type' => 'status_update',
                    'content' => 'Lead status changed to Design Discussion',
                    'lead_id' => $lead->id,
                    'direction' => 'outgoing',
                    'user_id' => Auth::id(),
                    'status' => 'sent',
                    'delivered_at' => now(),
                ]);
            }
        }
        
        // Check if assignment has changed
        if ($previousAssignedTo !== $validated['assigned_to'] && $validated['assigned_to']) {
            $assignedUser = User::find($validated['assigned_to']);
            
            // Create communication log entry for assignment
            CommunicationLog::create([
                'communication_type' => 'assignment',
                'content' => 'Lead assigned to ' . $assignedUser->name,
                'lead_id' => $lead->id,
                'direction' => 'internal',
                'user_id' => Auth::id(),
                'status' => 'sent',
                'delivered_at' => now(),
            ]);
            
            // If follow-up date is not set, set a default one for 2 days from now
            if (!isset($validated['follow_up_date']) || !$validated['follow_up_date']) {
                $lead->follow_up_date = now()->addDays(2);
                $lead->save();
                
                // Schedule follow-up reminder
                SendLeadFollowUpReminder::dispatch($lead)
                    ->delay(now()->diffInMinutes($lead->follow_up_date) * 60);
            }
        }
        
        // If follow-up date is set, schedule a reminder
        if (isset($validated['follow_up_date']) && $validated['follow_up_date']) {
            SendLeadFollowUpReminder::dispatch($lead)
                ->delay(now()->diffInMinutes($validated['follow_up_date']) * 60);
        }
        
        return redirect()->route('leads.show', $lead)
            ->with('success', 'Lead updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();
        
        return redirect()->route('leads.index')
            ->with('success', 'Lead deleted successfully');
    }
    
    /**
     * Convert lead to client
     */
    public function convertToClient(Lead $lead)
    {
        // Check authorization
        $this->authorize('convertToClient', $lead);
        
        // Check if already converted
        if ($lead->status === 'converted') {
            return redirect()->route('leads.show', $lead)
                ->with('error', 'This lead has already been converted to a client');
        }
        
        // Create client from lead
        $client = Client::create([
            'name' => $lead->name,
            'email' => $lead->email,
            'phone' => $lead->phone,
            'address' => $lead->address,
            'client_type' => 'Residential', // Default, can be changed later
            'lead_id' => $lead->id,
        ]);
        
        // Update lead status
        $lead->status = 'converted';
        $lead->save();
        
        // Create communication log entry
        CommunicationLog::create([
            'communication_type' => 'other',
            'content' => 'Lead converted to client',
            'lead_id' => $lead->id,
            'client_id' => $client->id,
            'direction' => 'outgoing',
            'user_id' => Auth::id(),
            'status' => 'sent',
            'delivered_at' => now(),
        ]);
        
        return redirect()->route('clients.show', $client)
            ->with('success', 'Lead has been successfully converted to a client');
    }
    
    /**
     * Display analytics dashboard for leads
     */
    public function analytics()
    {
        // Get lead counts by source
        $leadsBySource = Lead::selectRaw('source, count(*) as count')
            ->groupBy('source')
            ->orderByDesc('count')
            ->get();
            
        // Get lead counts by status
        $leadsByStatus = Lead::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->orderByDesc('count')
            ->get();
            
        // Get lead counts by source detail
        $leadsBySourceDetail = Lead::whereNotNull('source_detail')
            ->selectRaw('source_detail, count(*) as count')
            ->groupBy('source_detail')
            ->orderByDesc('count')
            ->get();
            
        // Get lead counts by source campaign
        $leadsBySourceCampaign = Lead::whereNotNull('source_campaign')
            ->selectRaw('source_campaign, count(*) as count')
            ->groupBy('source_campaign')
            ->orderByDesc('count')
            ->get();
            
        // Get conversion rates (leads that became clients)
        $totalLeads = Lead::count();
        $convertedLeads = Lead::where('status', 'converted')->count();
        $conversionRate = $totalLeads > 0 ? ($convertedLeads / $totalLeads) * 100 : 0;
            
        return view('leads.analytics', compact(
            'leadsBySource',
            'leadsByStatus',
            'leadsBySourceDetail',
            'leadsBySourceCampaign',
            'totalLeads',
            'convertedLeads',
            'conversionRate'
        ));
    }
}
