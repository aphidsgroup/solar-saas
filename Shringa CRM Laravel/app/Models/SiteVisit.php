<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SiteVisit extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lead_id',
        'client_id',
        'project_id',
        'visit_type',
        'visit_date',
        'start_time',
        'end_time',
        'address',
        'purpose',
        'status',
        'assigned_to',
        'client_notified',
        'reminder_sent',
        'checked_in_at',
        'checked_out_at',
        'observations',
        'action_items',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'visit_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'client_notified' => 'boolean',
        'reminder_sent' => 'boolean',
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
    ];
    
    /**
     * Get the lead associated with the site visit.
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }
    
    /**
     * Get the client associated with the site visit.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
    
    /**
     * Get the project associated with the site visit.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    
    /**
     * Get the user assigned to the site visit.
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    
    /**
     * Check if site visit is upcoming
     */
    public function isUpcoming(): bool
    {
        return $this->visit_date > now()->toDateString();
    }
    
    /**
     * Check if site visit is today
     */
    public function isToday(): bool
    {
        return $this->visit_date == now()->toDateString();
    }
    
    /**
     * Check if site visit is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
    
    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('site_visit_photos')
            ->useDisk('public');
            
        $this->addMediaCollection('site_visit_documents')
            ->useDisk('public');
    }
}
