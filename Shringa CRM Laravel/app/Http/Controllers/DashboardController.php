<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Lead;
use App\Models\Project;
use App\Models\SiteVisit;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with relevant statistics
     */
    public function index()
    {
        $user = Auth::user();
        
        // Basic statistics for all users
        $stats = [
            'total_leads' => Lead::count(),
            'total_clients' => Client::count(),
            'total_projects' => Project::count(),
            'total_invoices' => Invoice::count(),
        ];
        
        // User-specific data
        $myStats = [
            'assigned_leads' => Lead::where('assigned_to', $user->id)->count(),
            'assigned_projects' => Project::where('assigned_to', $user->id)->count(),
            'my_tasks' => Task::where('assigned_to', $user->id)->count(),
            'my_tasks_pending' => Task::where('assigned_to', $user->id)
                                      ->where('status', '!=', 'completed')
                                      ->count(),
        ];
        
        // Recent activities
        $recentLeads = Lead::orderBy('created_at', 'desc')->take(5)->get();
        $upcomingSiteVisits = SiteVisit::where('visit_date', '>=', now()->toDateString())
                                      ->orderBy('visit_date')
                                      ->take(5)
                                      ->get();
        
        // Financial statistics for admins
        $financialStats = [];
        if ($user->hasRole('admin')) {
            $financialStats = [
                'total_invoiced' => Invoice::sum('total'),
                'total_paid' => Invoice::sum('amount_paid'),
                'total_due' => Invoice::sum('amount_due'),
                'overdue_invoices' => Invoice::where('status', 'overdue')->count(),
            ];
        }
        
        // Project statistics
        $projectStats = [
            'active_projects' => Project::whereIn('status', ['concept', 'design', 'execution'])->count(),
            'completed_projects' => Project::where('status', 'completed')->count(),
        ];
        
        // Add project stats and pending tasks to the main stats array
        $stats['active_projects'] = $projectStats['active_projects'];
        $stats['pending_tasks'] = Task::where('status', '!=', 'completed')->count();
        
        // Create recent activities list
        $recent_activities = collect();
        
        // Get activities from the database, ordered by most recent
        $recent_activities = \App\Models\Activity::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // If no activities found, create some sample ones using our ActivityLogger
        if ($recent_activities->isEmpty()) {
            // Create sample activities using our logger
            \App\Helpers\ActivityLogger::log('lead', 'New lead created', [], ['source' => 'website']);
            \App\Helpers\ActivityLogger::log('client', 'Client information updated');
            \App\Helpers\ActivityLogger::log('project', 'Project status changed to "execution"');
            \App\Helpers\ActivityLogger::log('task', 'New task assigned');
            
            // Fetch the newly created activities
            $recent_activities = \App\Models\Activity::with('user')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        }
        
        // Pass recent leads as $recent_leads to match view variable name
        $recent_leads = $recentLeads;
        
        // Get a few projects for the project status section
        $projects = Project::orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        return view('dashboard', compact(
            'stats', 
            'myStats', 
            'recent_leads', 
            'upcomingSiteVisits', 
            'financialStats', 
            'projectStats',
            'user',
            'recent_activities',
            'projects'
        ));
    }
    
    /**
     * Display the users management page (admin only)
     */
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }
    
    /**
     * Display the settings page (admin only)
     */
    public function settings()
    {
        return view('admin.settings');
    }
    
    /**
     * Display performance reports (admin only)
     */
    public function performanceReports()
    {
        // Get team performance metrics
        $userPerformance = User::withCount(['leads', 'projects', 'siteVisits'])
                             ->get();
        
        // Get task completion rates by user
        $taskCompletionRates = User::select('users.id', 'users.name')
            ->selectRaw('COUNT(tasks.id) as total_tasks')
            ->selectRaw('SUM(CASE WHEN tasks.status = "completed" THEN 1 ELSE 0 END) as completed_tasks')
            ->selectRaw('(SUM(CASE WHEN tasks.status = "completed" THEN 1 ELSE 0 END) / COUNT(tasks.id)) * 100 as completion_rate')
            ->leftJoin('tasks', 'users.id', '=', 'tasks.assigned_to')
            ->groupBy('users.id', 'users.name')
            ->having('total_tasks', '>', 0)
            ->get();
            
        return view('admin.reports.performance', compact('userPerformance', 'taskCompletionRates'));
    }
    
    /**
     * Display sales reports (admin only)
     */
    public function salesReports()
    {
        // Get monthly sales data for the current year
        $monthlySales = Invoice::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as total_amount')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
            
        // Get lead conversion rates
        $leadStats = [
            'total_leads' => Lead::count(),
            'converted_leads' => Lead::where('status', 'converted')->count(),
            'conversion_rate' => Lead::count() > 0 
                ? (Lead::where('status', 'converted')->count() / Lead::count()) * 100 
                : 0,
        ];
        
        // Get sales by lead source
        $salesBySource = Lead::select('source')
            ->selectRaw('COUNT(id) as lead_count')
            ->selectRaw('SUM(CASE WHEN status = "converted" THEN 1 ELSE 0 END) as converted_count')
            ->groupBy('source')
            ->get();
            
        return view('admin.reports.sales', compact('monthlySales', 'leadStats', 'salesBySource'));
    }
    
    /**
     * Display project reports (admin only)
     */
    public function projectReports()
    {
        // Get project statistics by type
        $projectsByType = Project::select('type')
            ->selectRaw('COUNT(id) as count')
            ->groupBy('type')
            ->get();
            
        // Get average project duration
        $avgProjectDuration = Project::whereNotNull('actual_completion_date')
            ->selectRaw('AVG(DATEDIFF(actual_completion_date, start_date)) as avg_days')
            ->first();
            
        // Get project statuses distribution
        $projectStatusDistribution = Project::select('status')
            ->selectRaw('COUNT(id) as count')
            ->groupBy('status')
            ->get();
            
        return view('admin.reports.projects', compact(
            'projectsByType', 
            'avgProjectDuration', 
            'projectStatusDistribution'
        ));
    }
}
