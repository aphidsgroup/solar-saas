<?php

namespace App\Http\Controllers;

use App\Models\DailyReport;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class DailyReportController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(DailyReport::class, 'dailyReport');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // Get filter parameters
        $project_id = $request->input('project_id');
        $date_range = $request->input('date_range');
        $search = $request->input('search');
        
        // Base query
        $query = DailyReport::query()->with(['user', 'project.client']);
        
        // Apply filters if provided
        if ($project_id) {
            $query->where('project_id', $project_id);
        }
        
        if ($date_range) {
            switch ($date_range) {
                case 'today':
                    $query->whereDate('report_date', Carbon::today());
                    break;
                case 'yesterday':
                    $query->whereDate('report_date', Carbon::yesterday());
                    break;
                case 'this_week':
                    $query->whereBetween('report_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'last_week':
                    $query->whereBetween('report_date', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('report_date', Carbon::now()->month)->whereYear('report_date', Carbon::now()->year);
                    break;
                case 'last_month':
                    $query->whereMonth('report_date', Carbon::now()->subMonth()->month)->whereYear('report_date', Carbon::now()->subMonth()->year);
                    break;
            }
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('work_completed', 'like', "%{$search}%")
                  ->orWhere('challenges', 'like', "%{$search}%")
                  ->orWhere('next_steps', 'like', "%{$search}%")
                  ->orWhereHas('project', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Get projects for the filter dropdown
        $projects = Project::all();
        
        // Get paginated results
        $dailyReports = $query->latest('report_date')->paginate(10);
        
        return view('daily-reports.index', compact('dailyReports', 'projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $projects = Project::all();
        
        return view('daily-reports.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'report_date' => 'required|date',
            'work_completed' => 'required|string',
            'challenges' => 'nullable|string',
            'next_steps' => 'nullable|string',
            'hours_spent' => 'nullable|numeric|min:0',
            'shared_with_client' => 'boolean',
        ]);
        
        $dailyReport = new DailyReport();
        $dailyReport->project_id = $validated['project_id'];
        $dailyReport->report_date = $validated['report_date'];
        $dailyReport->work_completed = $validated['work_completed'];
        $dailyReport->challenges = $validated['challenges'] ?? null;
        $dailyReport->next_steps = $validated['next_steps'] ?? null;
        $dailyReport->hours_spent = $validated['hours_spent'] ?? null;
        $dailyReport->shared_with_client = $validated['shared_with_client'] ?? false;
        $dailyReport->user_id = auth()->id();
        
        $dailyReport->save();
        
        return redirect()->route('daily-reports.index')
            ->with('success', 'Daily report submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DailyReport $dailyReport): View
    {
        return view('daily-reports.show', compact('dailyReport'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailyReport $dailyReport): View
    {
        $projects = Project::all();
        
        return view('daily-reports.edit', compact('dailyReport', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DailyReport $dailyReport): RedirectResponse
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'report_date' => 'required|date',
            'work_completed' => 'required|string',
            'challenges' => 'nullable|string',
            'next_steps' => 'nullable|string',
            'hours_spent' => 'nullable|numeric|min:0',
            'shared_with_client' => 'boolean',
        ]);
        
        $dailyReport->project_id = $validated['project_id'];
        $dailyReport->report_date = $validated['report_date'];
        $dailyReport->work_completed = $validated['work_completed'];
        $dailyReport->challenges = $validated['challenges'] ?? null;
        $dailyReport->next_steps = $validated['next_steps'] ?? null;
        $dailyReport->hours_spent = $validated['hours_spent'] ?? null;
        $dailyReport->shared_with_client = $validated['shared_with_client'] ?? false;
        
        $dailyReport->save();
        
        return redirect()->route('daily-reports.index')
            ->with('success', 'Daily report updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyReport $dailyReport): RedirectResponse
    {
        $dailyReport->delete();
        
        return redirect()->route('daily-reports.index')
            ->with('success', 'Daily report deleted successfully.');
    }
    
    /**
     * Share a daily report with the client.
     */
    public function shareWithClient(DailyReport $dailyReport): RedirectResponse
    {
        // In a real application, this would likely send an email to the client as well
        $dailyReport->shared_with_client = true;
        $dailyReport->save();
        
        return redirect()->back()
            ->with('success', 'Daily report has been shared with the client.');
    }
}
