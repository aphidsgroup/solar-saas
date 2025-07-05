<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Client;
use App\Models\Project;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TaskController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // Get filter parameters
        $status = $request->input('status');
        $priority = $request->input('priority');
        $search = $request->input('search');
        
        // Base query
        $query = Task::query()->with(['taskable', 'assignedTo']);
        
        // Apply filters if provided
        if ($status) {
            $query->where('status', $status);
        }
        
        if ($priority) {
            $query->where('priority', $priority);
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Check for overdue tasks
        $query->where(function($q) {
            $q->where('status', '!=', 'completed')
              ->where(function($q) {
                  $q->where('due_date', '<', now())
                    ->orWhereNull('due_date');
              });
        })
        ->update(['status' => 'overdue']);
        
        // Get paginated results
        $tasks = $query->orderBy('due_date', 'asc')->paginate(10);
        
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $clients = Client::all();
        $projects = Project::all();
        $leads = Lead::all();
        $users = User::all();
        
        return view('tasks.create', compact('clients', 'projects', 'leads', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:pending,in_progress,completed,overdue',
            'priority' => 'required|string|in:low,medium,high,urgent',
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
            'taskable_type' => 'nullable|string',
            'taskable_id' => 'nullable|integer',
        ]);
        
        $task = new Task();
        $task->title = $validated['title'];
        $task->description = $validated['description'] ?? null;
        $task->status = $validated['status'];
        $task->priority = $validated['priority'];
        $task->due_date = $validated['due_date'] ?? null;
        $task->assigned_to = $validated['assigned_to'] ?? null;
        $task->user_id = auth()->id(); // Creator
        
        // Set polymorphic relationship if applicable
        if (!empty($validated['taskable_type']) && !empty($validated['taskable_id'])) {
            $taskableType = null;
            
            if ($validated['taskable_type'] === 'client') {
                $taskableType = Client::class;
            } elseif ($validated['taskable_type'] === 'project') {
                $taskableType = Project::class;
            } elseif ($validated['taskable_type'] === 'lead') {
                $taskableType = Lead::class;
            }
            
            if ($taskableType) {
                $task->taskable_type = $taskableType;
                $task->taskable_id = $validated['taskable_id'];
            }
        }
        
        $task->save();
        
        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): View
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task): View
    {
        $clients = Client::all();
        $projects = Project::all();
        $leads = Lead::all();
        $users = User::all();
        
        return view('tasks.edit', compact('task', 'clients', 'projects', 'leads', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:pending,in_progress,completed,overdue',
            'priority' => 'required|string|in:low,medium,high,urgent',
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
            'taskable_type' => 'nullable|string',
            'taskable_id' => 'nullable|integer',
        ]);
        
        $task->title = $validated['title'];
        $task->description = $validated['description'] ?? null;
        $task->status = $validated['status'];
        $task->priority = $validated['priority'];
        $task->due_date = $validated['due_date'] ?? null;
        $task->assigned_to = $validated['assigned_to'] ?? null;
        
        // Update polymorphic relationship if applicable
        if (!empty($validated['taskable_type']) && !empty($validated['taskable_id'])) {
            $taskableType = null;
            
            if ($validated['taskable_type'] === 'client') {
                $taskableType = Client::class;
            } elseif ($validated['taskable_type'] === 'project') {
                $taskableType = Project::class;
            } elseif ($validated['taskable_type'] === 'lead') {
                $taskableType = Lead::class;
            }
            
            if ($taskableType) {
                $task->taskable_type = $taskableType;
                $task->taskable_id = $validated['taskable_id'];
            }
        } else {
            $task->taskable_type = null;
            $task->taskable_id = null;
        }
        
        $task->save();
        
        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();
        
        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }
    
    /**
     * Mark a task as complete.
     */
    public function markComplete(Task $task): RedirectResponse
    {
        $task->status = 'completed';
        $task->completed_at = now();
        $task->save();
        
        return redirect()->back()
            ->with('success', 'Task marked as complete.');
    }
}
