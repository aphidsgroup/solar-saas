<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Check for overdue invoices and send reminders (daily at 9 AM)
        $schedule->command('app:check-overdue-invoices')
                 ->dailyAt('09:00')
                 ->timezone('Asia/Kolkata');
        
        // Check for upcoming site visits and send reminders (daily at 8 AM)
        $schedule->command('app:check-upcoming-site-visits')
                 ->dailyAt('08:00')
                 ->timezone('Asia/Kolkata');
        
        // Check for lead follow-ups due today (daily at 8:30 AM)
        $schedule->command('app:check-due-lead-follow-ups')
                 ->dailyAt('08:30')
                 ->timezone('Asia/Kolkata');
        
        // Run database backup (daily at midnight)
        $schedule->command('backup:run --only-db')
                 ->dailyAt('00:00')
                 ->timezone('Asia/Kolkata');
        
        // Clean old backups (weekly on Sundays at 1 AM)
        $schedule->command('backup:clean')
                 ->weekly()
                 ->sundays()
                 ->at('01:00')
                 ->timezone('Asia/Kolkata');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
} 