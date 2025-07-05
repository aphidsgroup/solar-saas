<?php

namespace App\Http\Controllers;

use App\Models\CommunicationLog;
use App\Models\Client;
use App\Models\Lead;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CommunicationLogController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(CommunicationLog::class, 'communicationLog');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // Get filter parameters
        $type = $request->input('type');
        $related_to = $request->input('related_to');
        $search = $request->input('search');
        
        // Base query
        $query = CommunicationLog::query()->with(['user', 'loggable']);
        
        // Apply filters if provided
        if ($type) {
            $query->where('type', $type);
        }
        
        if ($related_to) {
            if ($related_to === 'client') {
                $query->where('loggable_type', Client::class);
            } elseif ($related_to === 'lead') {
                $query->where('loggable_type', Lead::class);
            } elseif ($related_to === 'project') {
                $query->where('loggable_type', Project::class);
            }
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('contact_name', 'like', "%{$search}%")
                  ->orWhere('contact_email', 'like', "%{$search}%")
                  ->orWhere('contact_phone', 'like', "%{$search}%");
            });
        }
        
        // Get paginated results
        $communicationLogs = $query->latest('communication_date')->paginate(10);
        
        return view('communication-logs.index', compact('communicationLogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $clients = Client::all();
        $leads = Lead::all();
        $projects = Project::all();
        
        return view('communication-logs.create', compact('clients', 'leads', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|string|in:email,phone,meeting,message,other',
            'communication_date' => 'required|date',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'contact_name' => 'required|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'loggable_type' => 'nullable|string',
            'loggable_id' => 'nullable|integer',
        ]);
        
        $log = new CommunicationLog();
        $log->type = $validated['type'];
        $log->communication_date = $validated['communication_date'];
        $log->subject = $validated['subject'];
        $log->content = $validated['content'];
        $log->contact_name = $validated['contact_name'];
        $log->contact_email = $validated['contact_email'] ?? null;
        $log->contact_phone = $validated['contact_phone'] ?? null;
        $log->user_id = auth()->id();
        
        // Set polymorphic relationship if applicable
        if (!empty($validated['loggable_type']) && !empty($validated['loggable_id'])) {
            $loggableType = null;
            
            if ($validated['loggable_type'] === 'client') {
                $loggableType = Client::class;
            } elseif ($validated['loggable_type'] === 'lead') {
                $loggableType = Lead::class;
            } elseif ($validated['loggable_type'] === 'project') {
                $loggableType = Project::class;
            }
            
            if ($loggableType) {
                $log->loggable_type = $loggableType;
                $log->loggable_id = $validated['loggable_id'];
            }
        }
        
        $log->save();
        
        return redirect()->route('communication-logs.index')
            ->with('success', 'Communication log created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CommunicationLog $communicationLog): View
    {
        return view('communication-logs.show', compact('communicationLog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommunicationLog $communicationLog): View
    {
        $clients = Client::all();
        $leads = Lead::all();
        $projects = Project::all();
        
        return view('communication-logs.edit', compact('communicationLog', 'clients', 'leads', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommunicationLog $communicationLog): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|string|in:email,phone,meeting,message,other',
            'communication_date' => 'required|date',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'contact_name' => 'required|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'loggable_type' => 'nullable|string',
            'loggable_id' => 'nullable|integer',
        ]);
        
        $communicationLog->type = $validated['type'];
        $communicationLog->communication_date = $validated['communication_date'];
        $communicationLog->subject = $validated['subject'];
        $communicationLog->content = $validated['content'];
        $communicationLog->contact_name = $validated['contact_name'];
        $communicationLog->contact_email = $validated['contact_email'] ?? null;
        $communicationLog->contact_phone = $validated['contact_phone'] ?? null;
        
        // Update polymorphic relationship if applicable
        if (!empty($validated['loggable_type']) && !empty($validated['loggable_id'])) {
            $loggableType = null;
            
            if ($validated['loggable_type'] === 'client') {
                $loggableType = Client::class;
            } elseif ($validated['loggable_type'] === 'lead') {
                $loggableType = Lead::class;
            } elseif ($validated['loggable_type'] === 'project') {
                $loggableType = Project::class;
            }
            
            if ($loggableType) {
                $communicationLog->loggable_type = $loggableType;
                $communicationLog->loggable_id = $validated['loggable_id'];
            }
        } else {
            $communicationLog->loggable_type = null;
            $communicationLog->loggable_id = null;
        }
        
        $communicationLog->save();
        
        return redirect()->route('communication-logs.index')
            ->with('success', 'Communication log updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommunicationLog $communicationLog): RedirectResponse
    {
        $communicationLog->delete();
        
        return redirect()->route('communication-logs.index')
            ->with('success', 'Communication log deleted successfully.');
    }
}
