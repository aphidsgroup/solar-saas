<?php

namespace App\Http\Controllers;

use App\Models\SiteVisit;
use App\Models\Client;
use App\Models\Lead;
use App\Models\Project;
use App\Models\User;
use App\Models\CommunicationLog;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\PDF;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SiteVisitController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(SiteVisit::class, 'siteVisit');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // Get filter parameters
        $status = $request->input('status');
        $visit_type = $request->input('visit_type');
        $search = $request->input('search');
        $date_from = $request->input('date_from');
        $date_to = $request->input('date_to');
        $assigned_to = $request->input('assigned_to');
        
        // Base query
        $query = SiteVisit::query()->with(['client', 'lead', 'project', 'assignedUser']);
        
        // Apply filters if provided
        if ($status) {
            $query->where('status', $status);
        }
        
        if ($visit_type) {
            $query->where('visit_type', $visit_type);
        }
        
        if ($assigned_to) {
            $query->where('assigned_to', $assigned_to);
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('client', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('company_name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('lead', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('project', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('purpose', 'like', "%{$search}%");
            });
        }
        
        // Date range filter
        if ($date_from) {
            $query->whereDate('visit_date', '>=', $date_from);
        }
        
        if ($date_to) {
            $query->whereDate('visit_date', '<=', $date_to);
        }
        
        // Get paginated results
        $siteVisits = $query->orderBy('visit_date', 'desc')->paginate(10);
        
        // Get data for filters
        $visitTypes = $this->getVisitTypes();
        $statuses = $this->getStatuses();
        $users = User::all();
        
        // Get upcoming and today visits for quick access
        $upcomingVisits = SiteVisit::where('visit_date', '>=', now()->toDateString())
                        ->where('visit_date', '<=', now()->addDays(7)->toDateString())
                        ->orderBy('visit_date')
                        ->orderBy('start_time')
                        ->with(['client', 'project', 'assignedUser'])
                        ->take(5)
                        ->get();
                        
        $todayVisits = SiteVisit::where('visit_date', now()->toDateString())
                     ->orderBy('start_time')
                     ->with(['client', 'project', 'assignedUser'])
                     ->get();
        
        return view('site-visits.index', compact(
            'siteVisits', 
            'visitTypes', 
            'statuses', 
            'users', 
            'upcomingVisits', 
            'todayVisits'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get data for dropdowns
        $clients = Client::orderBy('name')->get();
        $leads = Lead::orderBy('name')->get();
        $projects = Project::orderBy('name')->get();
        $users = User::all();
        $visitTypes = $this->getVisitTypes();
        $statuses = $this->getStatuses();
        
        return view('site-visits.create', compact(
            'clients', 
            'leads', 
            'projects', 
            'users', 
            'visitTypes', 
            'statuses'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'lead_id' => 'nullable|exists:leads,id',
            'project_id' => 'nullable|exists:projects,id',
            'visit_type' => 'required|string',
            'visit_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'address' => 'required|string',
            'purpose' => 'required|string',
            'status' => 'required|string',
            'assigned_to' => 'required|exists:users,id',
            'observations' => 'nullable|string',
            'action_items' => 'nullable|string',
        ]);
        
        // Format start and end times
        $validated['start_time'] = Carbon::parse($validated['visit_date'] . ' ' . $validated['start_time']);
        $validated['end_time'] = Carbon::parse($validated['visit_date'] . ' ' . $validated['end_time']);
        
        // Create the site visit
        $siteVisit = SiteVisit::create($validated);
        
        return redirect()->route('site-visits.show', $siteVisit)
            ->with('success', 'Site visit scheduled successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(SiteVisit $siteVisit)
    {
        // Load relationships
        $siteVisit->load(['client', 'lead', 'project', 'assignedUser']);
        
        // Get visit photos
        $photos = $siteVisit->getMedia('site_visit_photos');
        
        // Get visit documents
        $documents = $siteVisit->getMedia('site_visit_documents');
        
        return view('site-visits.show', compact('siteVisit', 'photos', 'documents'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SiteVisit $siteVisit)
    {
        // Get data for dropdowns
        $clients = Client::orderBy('name')->get();
        $leads = Lead::orderBy('name')->get();
        $projects = Project::orderBy('name')->get();
        $users = User::all();
        $visitTypes = $this->getVisitTypes();
        $statuses = $this->getStatuses();
        
        // Format times for form
        $startTime = $siteVisit->start_time ? $siteVisit->start_time->format('H:i') : null;
        $endTime = $siteVisit->end_time ? $siteVisit->end_time->format('H:i') : null;
        
        return view('site-visits.edit', compact(
            'siteVisit',
            'clients', 
            'leads', 
            'projects', 
            'users', 
            'visitTypes', 
            'statuses',
            'startTime',
            'endTime'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SiteVisit $siteVisit)
    {
        // Validate the request
        $validated = $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'lead_id' => 'nullable|exists:leads,id',
            'project_id' => 'nullable|exists:projects,id',
            'visit_type' => 'required|string',
            'visit_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'address' => 'required|string',
            'purpose' => 'required|string',
            'status' => 'required|string',
            'assigned_to' => 'required|exists:users,id',
            'observations' => 'nullable|string',
            'action_items' => 'nullable|string',
        ]);
        
        // Format start and end times
        $validated['start_time'] = Carbon::parse($validated['visit_date'] . ' ' . $validated['start_time']);
        $validated['end_time'] = Carbon::parse($validated['visit_date'] . ' ' . $validated['end_time']);
        
        // Check if assigned person has changed
        $assignedChanged = $siteVisit->assigned_to != $validated['assigned_to'];
        
        // Update the site visit
        $siteVisit->update($validated);
        
        // If assigned person changed, reset client notification status
        if ($assignedChanged) {
            $siteVisit->client_notified = false;
            $siteVisit->save();
        }
        
        return redirect()->route('site-visits.show', $siteVisit)
            ->with('success', 'Site visit updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SiteVisit $siteVisit)
    {
        // Check if the site visit is already completed
        if ($siteVisit->status === 'completed') {
            return redirect()->route('site-visits.index')
                ->with('error', 'Cannot delete a completed site visit');
        }
        
        $siteVisit->delete();
        
        return redirect()->route('site-visits.index')
            ->with('success', 'Site visit deleted successfully');
    }
    
    /**
     * Check in for a site visit.
     */
    public function checkIn(SiteVisit $siteVisit)
    {
        $siteVisit->checked_in_at = now();
        $siteVisit->status = 'ongoing';
        $siteVisit->save();
        
        // Create communication log entry
        if ($siteVisit->client_id) {
            CommunicationLog::create([
                'communication_type' => 'site_visit',
                'content' => "Site visit check-in at " . now()->format('H:i') . " by " . Auth::user()->name,
                'client_id' => $siteVisit->client_id,
                'project_id' => $siteVisit->project_id,
                'direction' => 'internal',
                'user_id' => Auth::id(),
                'status' => 'sent',
                'delivered_at' => now(),
            ]);
        }
        
        return redirect()->back()->with('success', 'Successfully checked in for the site visit.');
    }
    
    /**
     * Check out from a site visit.
     */
    public function checkOut(Request $request, SiteVisit $siteVisit)
    {
        // Validate observations and action items
        $validated = $request->validate([
            'observations' => 'nullable|string',
            'action_items' => 'nullable|string',
        ]);
        
        // Update observations and action items if provided
        if (isset($validated['observations'])) {
            $siteVisit->observations = $validated['observations'];
        }
        
        if (isset($validated['action_items'])) {
            $siteVisit->action_items = $validated['action_items'];
        }
        
        $siteVisit->checked_out_at = now();
        $siteVisit->status = 'completed';
        $siteVisit->save();
        
        // Create communication log entry
        if ($siteVisit->client_id) {
            CommunicationLog::create([
                'communication_type' => 'site_visit',
                'content' => "Site visit completed at " . now()->format('H:i') . " by " . Auth::user()->name,
                'client_id' => $siteVisit->client_id,
                'project_id' => $siteVisit->project_id,
                'direction' => 'internal',
                'user_id' => Auth::id(),
                'status' => 'sent',
                'delivered_at' => now(),
            ]);
        }
        
        return redirect()->back()->with('success', 'Successfully checked out from the site visit.');
    }
    
    /**
     * Notify client about site visit.
     */
    public function notifyClient(Request $request, SiteVisit $siteVisit)
    {
        // Validate request
        $validated = $request->validate([
            'message' => 'nullable|string',
        ]);
        
        // In a real application, you would send an email or SMS to the client here
        $message = $validated['message'] ?? "Your site visit is scheduled for " . 
                 $siteVisit->visit_date->format('M d, Y') . " at " . 
                 $siteVisit->start_time->format('h:i A') . ". " .
                 "Our representative " . ($siteVisit->assignedUser ? $siteVisit->assignedUser->name : 'a team member') . 
                 " will be visiting.";
                 
        // Update notification status
        $siteVisit->client_notified = true;
        $siteVisit->save();
        
        // Create communication log entry
        if ($siteVisit->client_id) {
            CommunicationLog::create([
                'communication_type' => 'email',
                'content' => $message,
                'client_id' => $siteVisit->client_id,
                'project_id' => $siteVisit->project_id,
                'direction' => 'outgoing',
                'user_id' => Auth::id(),
                'status' => 'sent',
                'delivered_at' => now(),
            ]);
        } elseif ($siteVisit->lead_id) {
            CommunicationLog::create([
                'communication_type' => 'email',
                'content' => $message,
                'lead_id' => $siteVisit->lead_id,
                'direction' => 'outgoing',
                'user_id' => Auth::id(),
                'status' => 'sent',
                'delivered_at' => now(),
            ]);
        }
        
        return redirect()->back()->with('success', 'Client has been notified about the site visit.');
    }
    
    /**
     * Upload photos for a site visit.
     */
    public function uploadPhotos(Request $request, SiteVisit $siteVisit)
    {
        // Validate the request
        $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'required|image|max:5120', // 5MB max size
        ]);
        
        // Upload each photo
        foreach ($request->file('photos') as $photo) {
            $siteVisit->addMedia($photo)
                     ->usingName('Site Visit Photo - ' . now()->format('Y-m-d H:i:s'))
                     ->toMediaCollection('site_visit_photos');
        }
        
        return redirect()->route('site-visits.show', $siteVisit)
            ->with('success', 'Photos uploaded successfully');
    }
    
    /**
     * Upload documents for a site visit.
     */
    public function uploadDocuments(Request $request, SiteVisit $siteVisit)
    {
        // Validate the request
        $request->validate([
            'documents' => 'required|array',
            'documents.*' => 'required|file|max:10240', // 10MB max size
        ]);
        
        // Upload each document
        foreach ($request->file('documents') as $document) {
            $siteVisit->addMedia($document)
                     ->usingName('Site Visit Document - ' . $document->getClientOriginalName())
                     ->toMediaCollection('site_visit_documents');
        }
        
        return redirect()->route('site-visits.show', $siteVisit)
            ->with('success', 'Documents uploaded successfully');
    }
    
    /**
     * Generate report for a site visit.
     */
    public function generateReport(SiteVisit $siteVisit)
    {
        // Load relationships
        $siteVisit->load(['client', 'lead', 'project', 'assignedUser']);
        
        // Get visit photos
        $photos = $siteVisit->getMedia('site_visit_photos');
        
        // Generate PDF
        $pdf = PDF::loadView('site-visits.report', compact('siteVisit', 'photos'));
        
        // Set PDF options
        $pdf->setPaper('a4');
        
        // Return PDF for download
        return $pdf->download("site-visit-report-{$siteVisit->id}.pdf");
    }
    
    /**
     * Share report with client.
     */
    public function shareReport(SiteVisit $siteVisit)
    {
        // Generate PDF report
        $siteVisit->load(['client', 'lead', 'project', 'assignedUser']);
        $photos = $siteVisit->getMedia('site_visit_photos');
        $pdf = PDF::loadView('site-visits.report', compact('siteVisit', 'photos'));
        
        // Save the report
        $filename = "site-visit-report-{$siteVisit->id}.pdf";
        $path = 'site-visits/reports/' . $filename;
        Storage::disk('public')->put($path, $pdf->output());
        
        // Create a document record
        if ($siteVisit->project_id) {
            Document::create([
                'name' => "Site Visit Report - " . $siteVisit->visit_date->format('M d, Y'),
                'file_path' => $path,
                'document_type' => 'site_visit_report',
                'project_id' => $siteVisit->project_id,
                'client_id' => $siteVisit->client_id,
                'description' => "Site visit report for visit on " . $siteVisit->visit_date->format('M d, Y'),
                'uploaded_by' => Auth::id(),
            ]);
        }
        
        // Create communication log entry
        if ($siteVisit->client_id) {
            CommunicationLog::create([
                'communication_type' => 'email',
                'content' => "Site visit report for visit on " . $siteVisit->visit_date->format('M d, Y') . " has been shared.",
                'client_id' => $siteVisit->client_id,
                'project_id' => $siteVisit->project_id,
                'direction' => 'outgoing',
                'user_id' => Auth::id(),
                'status' => 'sent',
                'delivered_at' => now(),
            ]);
        }
        
        return redirect()->route('site-visits.show', $siteVisit)
            ->with('success', 'Site visit report has been shared with the client');
    }
    
    /**
     * Get available visit types.
     */
    private function getVisitTypes(): array
    {
        return [
            'initial_consultation' => 'Initial Consultation',
            'measurement' => 'Site Measurement',
            'progress_check' => 'Progress Check',
            'design_presentation' => 'Design Presentation',
            'material_selection' => 'Material Selection',
            'final_inspection' => 'Final Inspection',
            'client_complaint' => 'Client Complaint',
            'warranty_issue' => 'Warranty Issue',
            'other' => 'Other',
        ];
    }
    
    /**
     * Get available statuses.
     */
    private function getStatuses(): array
    {
        return [
            'scheduled' => 'Scheduled',
            'confirmed' => 'Confirmed',
            'ongoing' => 'Ongoing',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            'rescheduled' => 'Rescheduled',
        ];
    }
    
    /**
     * Calendar view of all site visits.
     */
    public function calendar()
    {
        // Get all site visits for the next 30 days
        $siteVisits = SiteVisit::where('visit_date', '>=', now()->subDays(7))
                            ->where('visit_date', '<=', now()->addDays(30))
                            ->with(['client', 'project', 'assignedUser'])
                            ->get();
        
        // Format for calendar view
        $events = $siteVisits->map(function($visit) {
            return [
                'id' => $visit->id,
                'title' => ($visit->client ? $visit->client->name : 'No Client') . ' - ' . $visit->visit_type,
                'start' => $visit->start_time->format('Y-m-d\TH:i:s'),
                'end' => $visit->end_time->format('Y-m-d\TH:i:s'),
                'url' => route('site-visits.show', $visit),
                'color' => $this->getStatusColor($visit->status),
                'extendedProps' => [
                    'status' => $visit->status,
                    'assignee' => $visit->assignedUser ? $visit->assignedUser->name : 'Unassigned',
                    'address' => $visit->address,
                ]
            ];
        });
        
        return view('site-visits.calendar', compact('events'));
    }
    
    /**
     * Get color for visit status.
     */
    private function getStatusColor(string $status): string
    {
        return match($status) {
            'scheduled' => '#3788d8', // Blue
            'confirmed' => '#8e24aa', // Purple
            'ongoing' => '#f9a825', // Yellow
            'completed' => '#4caf50', // Green
            'cancelled' => '#e53935', // Red
            'rescheduled' => '#ff9800', // Orange
            default => '#757575', // Grey
        };
    }
}
