<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lead extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'source',
        'source_detail',
        'source_campaign',
        'status',
        'requirements',
        'notes',
        'assigned_to',
        'follow_up_date',
        'last_contacted_at',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'follow_up_date' => 'datetime',
        'last_contacted_at' => 'datetime',
    ];
    
    /**
     * Get the status label for display
     *
     * @return string
     */
    public function getStatusLabelAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->status));
    }
    
    /**
     * Get the status color class
     *
     * @return string
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'new' => 'bg-blue-100 text-blue-800',
            'contacted' => 'bg-yellow-100 text-yellow-800',
            'quoted' => 'bg-purple-100 text-purple-800',
            'design_discussion' => 'bg-indigo-100 text-indigo-800',
            'converted' => 'bg-green-100 text-green-800',
            'lost' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
    
    /**
     * Get the user that is assigned to the lead.
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    
    /**
     * Get the client associated with the lead.
     */
    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }
    
    /**
     * Get the quotations for the lead.
     */
    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }
    
    /**
     * Get the site visits for the lead.
     */
    public function siteVisits(): HasMany
    {
        return $this->hasMany(SiteVisit::class);
    }
    
    /**
     * Get the communication logs for the lead.
     */
    public function communicationLogs(): HasMany
    {
        return $this->hasMany(CommunicationLog::class);
    }
}
