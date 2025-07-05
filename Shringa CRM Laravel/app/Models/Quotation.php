<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Quotation extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quotation_number',
        'lead_id',
        'client_id',
        'template_used',
        'scope_type',
        'fee_structure',
        'subtotal',
        'gst_percentage',
        'gst_amount',
        'total',
        'terms_and_conditions',
        'status',
        'sent_at',
        'viewed_at',
        'expiry_date',
        'notes',
        'items',
        'share_link_token',
        'brand_style',
        'last_viewed_by_client_at',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'subtotal' => 'decimal:2',
        'gst_percentage' => 'decimal:2',
        'gst_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'sent_at' => 'datetime',
        'viewed_at' => 'datetime',
        'expiry_date' => 'datetime',
        'last_viewed_by_client_at' => 'datetime',
        'items' => 'array',
    ];
    
    /**
     * Define available templates
     */
    public static function availableTemplates(): array
    {
        return [
            'standard' => 'Standard Proposal',
            'premium' => 'Premium Proposal with Images',
            'detailed' => 'Detailed Scope Proposal',
            'simple' => 'Simple Quotation',
        ];
    }
    
    /**
     * Define available scope types
     */
    public static function availableScopeTypes(): array
    {
        return [
            'residential' => 'Residential',
            'commercial' => 'Commercial',
            'retail' => 'Retail',
        ];
    }
    
    /**
     * Define available fee structures
     */
    public static function availableFeeStructures(): array
    {
        return [
            'per_room' => 'Per Room',
            'per_sqft' => 'Per Square Foot',
            'package' => 'Fixed Package',
        ];
    }
    
    /**
     * Define available statuses
     */
    public static function availableStatuses(): array
    {
        return [
            'draft' => 'Draft',
            'sent' => 'Sent',
            'viewed' => 'Viewed',
            'accepted' => 'Accepted',
            'rejected' => 'Rejected',
            'expired' => 'Expired',
        ];
    }
    
    /**
     * Define available brand styles
     */
    public static function availableBrandStyles(): array
    {
        return [
            'classic' => 'Classic',
            'modern' => 'Modern',
            'minimalist' => 'Minimalist',
            'luxury' => 'Luxury',
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
            'viewed' => 'bg-indigo-100 text-indigo-800',
            'accepted' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            'expired' => 'bg-orange-100 text-orange-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
    
    /**
     * Get the lead associated with the quotation.
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }
    
    /**
     * Get the client associated with the quotation.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
    
    /**
     * Get the quotation items.
     */
    public function quotationItems(): HasMany
    {
        return $this->hasMany(QuotationItem::class);
    }
    
    /**
     * Generate a unique quotation number
     */
    public static function generateQuotationNumber(): string
    {
        $latestQuotation = self::latest()->first();
        $nextId = $latestQuotation ? $latestQuotation->id + 1 : 1;
        return 'Q-' . date('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }
    
    /**
     * Generate a unique share link token
     */
    public static function generateShareLinkToken(): string
    {
        return md5(uniqid(rand(), true));
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
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('quotation_files')
            ->useDisk('public');
        
        $this->addMediaCollection('project_images')
            ->useDisk('public');
    }
}
