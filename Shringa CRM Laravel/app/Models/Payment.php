<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Payment extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'payment_number',
        'invoice_id',
        'client_id',
        'amount',
        'payment_date',
        'payment_method',
        'transaction_id',
        'payment_status',
        'notes',
        'receipt_generated',
        'receipt_sent',
        'received_by',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
        'receipt_generated' => 'boolean',
        'receipt_sent' => 'boolean',
    ];
    
    /**
     * Get the invoice associated with the payment.
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
    
    /**
     * Get the client associated with the payment.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
    
    /**
     * Get the user who received the payment.
     */
    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }
    
    /**
     * Generate a unique payment number
     */
    public static function generatePaymentNumber(): string
    {
        $latestPayment = self::latest()->first();
        $nextId = $latestPayment ? $latestPayment->id + 1 : 1;
        return 'PAY-' . date('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }
    
    /**
     * Available payment methods
     */
    public static function availablePaymentMethods(): array
    {
        return [
            'cash' => 'Cash',
            'check' => 'Check/Cheque',
            'bank_transfer' => 'Bank Transfer',
            'upi' => 'UPI',
            'credit_card' => 'Credit Card',
            'debit_card' => 'Debit Card',
            'online_payment' => 'Online Payment',
            'other' => 'Other',
        ];
    }
    
    /**
     * Available payment statuses
     */
    public static function availablePaymentStatuses(): array
    {
        return [
            'completed' => 'Completed',
            'pending' => 'Pending',
            'failed' => 'Failed',
            'refunded' => 'Refunded',
        ];
    }
    
    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('payment_receipts')
            ->useDisk('public');
            
        $this->addMediaCollection('payment_proofs')
            ->useDisk('public');
    }
}
