<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use App\Notifications\ClientCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Client::class);
        
        // Get filter parameters
        $status = $request->input('status');
        $type = $request->input('type');
        $search = $request->input('search');
        
        // Base query
        $query = Client::query();
        
        // Apply filters if provided
        if ($status) {
            $query->where('status', $status);
        }
        
        if ($type) {
            $query->where('client_type', $type);
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Get paginated results
        $clients = $query->orderBy('name')->paginate(10);
        
        // Get client types for filters
        $clientTypes = ['Residential', 'Commercial', 'Office', 'Other'];
        
        return view('clients.index', compact('clients', 'clientTypes', 'status', 'type', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Client::class);
        
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        $this->authorize('create', Client::class);
        
        // Get validated data
        $validated = $request->validated();
        
        // Set default status
        $validated['status'] = 'active';
        
        // Create the client
        $client = Client::create($validated);
        
        // Send notification to admin users and project managers
        $adminsAndPMs = User::whereIn('role', ['admin', 'pm'])->get();
        Notification::send($adminsAndPMs, new ClientCreatedNotification($client));
        
        return redirect()->route('clients.show', $client)
            ->with('success', 'Client created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $this->authorize('view', $client);
        
        // Load relationships
        $client->load(['projects', 'quotations', 'invoices', 'siteVisits', 'documents']);
        
        // Get statistics
        $stats = [
            'total_projects' => $client->projects->count(),
            'ongoing_projects' => $client->projects->where('status', '!=', 'completed')->count(),
            'total_invoices' => $client->invoices->count(),
            'pending_amount' => $client->invoices->sum('amount_due'),
        ];
        
        return view('clients.show', compact('client', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        $this->authorize('update', $client);
        
        $clientTypes = ['Residential', 'Commercial', 'Office', 'Other'];
        $statusOptions = ['active', 'inactive', 'archived'];
        
        return view('clients.edit', compact('client', 'clientTypes', 'statusOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $this->authorize('update', $client);
        
        // Get validated data
        $validated = $request->validated();
        
        // Update the client
        $client->update($validated);
        
        return redirect()->route('clients.show', $client)
            ->with('success', 'Client updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $this->authorize('delete', $client);
        
        // Check if client has projects
        if ($client->projects()->exists()) {
            return redirect()->route('clients.show', $client)
                ->with('error', 'Cannot delete client with existing projects');
        }
        
        // Delete the client
        $client->delete();
        
        return redirect()->route('clients.index')
            ->with('success', 'Client deleted successfully');
    }
    
    /**
     * Show client projects.
     */
    public function projects(Client $client)
    {
        $this->authorize('viewProjects', $client);
        
        // Load projects with relationships
        $projects = $client->projects()->with(['quotations', 'invoices', 'tasks'])->get();
        
        // Group projects by status
        $groupedProjects = [
            'concept' => $projects->where('status', 'concept'),
            'design' => $projects->where('status', 'design'),
            'execution' => $projects->where('status', 'execution'),
            'completed' => $projects->where('status', 'completed'),
        ];
        
        return view('clients.projects', compact('client', 'groupedProjects'));
    }
    
    /**
     * Show client financials.
     */
    public function financials(Client $client)
    {
        $this->authorize('viewFinancials', $client);
        
        // Load financial relationships
        $client->load(['quotations', 'invoices']);
        
        // Get financial summary
        $summary = [
            'total_quoted' => $client->quotations->sum('total'),
            'total_invoiced' => $client->invoices->sum('total'),
            'total_paid' => $client->invoices->sum('amount_paid'),
            'total_due' => $client->invoices->sum('amount_due'),
            'overdue_invoices' => $client->invoices->where('status', 'overdue')->count(),
        ];
        
        return view('clients.financials', compact('client', 'summary'));
    }
}
