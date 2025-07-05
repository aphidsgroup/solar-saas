<?php

namespace App\Console\Commands;

use App\Jobs\SendInvoiceOverdueReminder;
use App\Models\Invoice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckOverdueInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-overdue-invoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for overdue invoices and send reminder emails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for overdue invoices...');
        
        // Find all unpaid/partially paid invoices that are past due date
        $overdueInvoices = Invoice::where('status', '!=', 'paid')
            ->where('due_date', '<', now()->toDateString())
            ->get();
        
        $count = $overdueInvoices->count();
        $this->info("Found {$count} overdue invoices");
        
        foreach ($overdueInvoices as $invoice) {
            // Update status to overdue if not already
            if ($invoice->status !== 'overdue') {
                $invoice->status = 'overdue';
                $invoice->save();
                
                $this->info("Invoice #{$invoice->invoice_number} marked as overdue");
            }
            
            // Dispatch job to send overdue reminder
            SendInvoiceOverdueReminder::dispatch($invoice);
            $this->info("Reminder queued for invoice #{$invoice->invoice_number}");
        }
        
        Log::info("Overdue invoice check completed. {$count} invoices processed.");
        
        return Command::SUCCESS;
    }
}
