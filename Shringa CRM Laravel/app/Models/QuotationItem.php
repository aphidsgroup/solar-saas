<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuotationItem extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quotation_id',
        'description',
        'quantity',
        'unit',
        'unit_price',
        'amount',
        'sort_order',
        'is_section_header',
        'notes',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'amount' => 'decimal:2',
        'is_section_header' => 'boolean',
    ];
    
    /**
     * Get the quotation that owns the item.
     */
    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }
    
    /**
     * Calculate the amount based on quantity and unit price
     */
    public function calculateAmount(): float
    {
        return round($this->quantity * $this->unit_price, 2);
    }
}
