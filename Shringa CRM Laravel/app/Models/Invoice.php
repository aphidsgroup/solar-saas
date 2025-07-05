<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Invoice extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_number',
        'project_id',
        'client_id',
        'milestone_type',
        'due_date',
        'subtotal',
        'gst_percentage',
        'gst_amount',
        'total',
        'amount_paid',
        'amount_due',
        'status',
        'payment_details',
        'notes',
        'paid_at',
        'overdue_notified',
        'reminder_sent_at',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'gst_percentage' => 'decimal:2',
        'gst_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'amount_due' => 'decimal:2',
        'paid_at' => 'datetime',
        'overdue_notified' => 'boolean',
        'reminder_sent_at' => 'datetime',
    ];
    
    /**
     * Get the project associated with the invoice.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    
    /**
     * Get the client associated with the invoice.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
    
    /**
     * Get the payments for the invoice.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
    
    /**
     * Generate a unique invoice number
     */
    public static function generateInvoiceNumber(): string
    {
        $latestInvoice = self::latest()->first();
        $nextId = $latestInvoice ? $latestInvoice->id + 1 : 1;
        return 'INV-' . date('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }
    
    /**
     * Calculate GST amount
     */
    public function calculateGstAmount(): float
    {
        return round(($this->subtotal * $this->gst_percentage) / 100, 2);
    }
    
    /**
     * Calculate total amount
     */
    public function calculateTotal(): float
    {
        return round($this->subtotal + $this->gst_amount, 2);
    }
    
    /**
     * Calculate amount due
     */
    public function calculateAmountDue(): float
    {
        return round($this->total - $this->amount_paid, 2);
    }
    
    /**
     * Check if invoice is overdue
     */
    public function isOverdue(): bool
    {
        return $this->status !== 'paid' && $this->due_date < now()->toDateString();
    }
    
    /**
     * Available milestone types
     */
    public static function availableMilestoneTypes(): array
    {
        return [
            'advance_payment' => 'Advance Payment',
            'mid_payment' => 'Mid-Project Payment',
            'final_payment' => 'Final Payment',
            'additional_work' => 'Additional Work',
            'material_cost' => 'Material Cost',
            'labor_cost' => 'Labor Cost',
        ];
    }
    
    /**
     * Available invoice statuses
     */
    public static function availableStatuses(): array
    {
        return [
            'draft' => 'Draft',
            'sent' => 'Sent',
            'partially_paid' => 'Partially Paid',
            'paid' => 'Paid',
            'overdue' => 'Overdue',
            'cancelled' => 'Cancelled',
        ];
    }
    
    /**
     * Get the status color class
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'draft' => 'bg-gray-100 text-gray-800',
            'sent' => 'bg-blue-100 text-blue-800',
            'partially_paid' => 'bg-indigo-100 text-indigo-800',
            'paid' => 'bg-green-100 text-green-800',
            'overdue' => 'bg-red-100 text-red-800',
            'cancelled' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
    
    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('invoice_files')
            ->useDisk('public');
    }
}
