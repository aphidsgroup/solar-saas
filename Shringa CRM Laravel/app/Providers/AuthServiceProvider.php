<?php

namespace App\Providers;

use App\Models\Lead;
use App\Models\Client;
use App\Models\Project;
use App\Models\Quotation;
use App\Models\Invoice;
use App\Models\SiteVisit;
use App\Models\Document;
use App\Models\Task;
use App\Models\DailyReport;
use App\Models\CommunicationLog;
use App\Policies\LeadPolicy;
use App\Policies\ClientPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\QuotationPolicy;
use App\Policies\InvoicePolicy;
use App\Policies\SiteVisitPolicy;
use App\Policies\DocumentPolicy;
use App\Policies\TaskPolicy;
use App\Policies\DailyReportPolicy;
use App\Policies\CommunicationLogPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Lead::class => LeadPolicy::class,
        Client::class => ClientPolicy::class,
        Project::class => ProjectPolicy::class,
        Quotation::class => QuotationPolicy::class,
        Invoice::class => InvoicePolicy::class,
        SiteVisit::class => SiteVisitPolicy::class,
        Document::class => DocumentPolicy::class,
        Task::class => TaskPolicy::class,
        DailyReport::class => DailyReportPolicy::class,
        CommunicationLog::class => CommunicationLogPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Register role-based gates
        Gate::define('admin', function ($user) {
            return $user->hasRole('admin');
        });

        Gate::define('designer', function ($user) {
            return $user->hasRole('designer') || $user->hasRole('admin');
        });

        Gate::define('pm', function ($user) {
            return $user->hasRole('pm') || $user->hasRole('admin');
        });

        Gate::define('engineer', function ($user) {
            return $user->hasRole('engineer') || $user->hasRole('admin');
        });
    }
}
