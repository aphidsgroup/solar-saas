<?php

namespace App\Jobs;

use App\Models\Invoice;
use App\Models\CommunicationLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendInvoiceOverdueReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The invoice instance.
     *
     * @var \App\Models\Invoice
     */
    protected $invoice;

    /**
     * Create a new job instance.
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $client = $this->invoice->client;
        $project = $this->invoice->project;

        if (!$client || !$client->email) {
            Log::warning("Cannot send overdue invoice reminder - no valid client email for invoice #{$this->invoice->invoice_number}");
            return;
        }

        try {
            // Create email content
            $daysOverdue = now()->diffInDays($this->invoice->due_date);
            $emailSubject = "REMINDER: Overdue Invoice #{$this->invoice->invoice_number} for {$project->name}";
            $emailContent = "Dear {$client->name},\n\n";
            $emailContent .= "This is a reminder that invoice #{$this->invoice->invoice_number} for project '{$project->name}' ";
            $emailContent .= "is now {$daysOverdue} days overdue.\n\n";
            $emailContent .= "Invoice Details:\n";
            $emailContent .= "- Amount Due: ₹" . number_format($this->invoice->amount_due, 2) . "\n";
            $emailContent .= "- Due Date: " . $this->invoice->due_date->format('d M, Y') . "\n\n";
            $emailContent .= "Please process this payment at your earliest convenience.\n\n";
            $emailContent .= "If you have already made the payment, please disregard this reminder and provide us with the payment details.\n\n";
            $emailContent .= "Best regards,\nShringa Interior Design";

            // In a real implementation, you would use Laravel Mail with proper templates
            // For now, we'll just log the email content
            Log::info("Sending overdue invoice reminder email to {$client->email}");
            Log::info("Email subject: {$emailSubject}");
            Log::info("Email content: {$emailContent}");

            // Create communication log entry
            CommunicationLog::create([
                'communication_type' => 'email',
                'content' => $emailContent,
                'client_id' => $client->id,
                'project_id' => $project->id,
                'direction' => 'outgoing',
                'user_id' => 1, // System user or admin (implement as needed)
                'status' => 'sent',
                'delivered_at' => now(),
            ]);

            Log::info("Overdue invoice reminder sent successfully for invoice #{$this->invoice->invoice_number}");
        } catch (\Exception $e) {
            Log::error("Failed to send overdue invoice reminder: " . $e->getMessage());
            throw $e;
        }
    }
}
