<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Project extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'client_id',
        'type',
        'area',
        'area_unit',
        'status',
        'start_date',
        'estimated_completion_date',
        'actual_completion_date',
        'budget',
        'assigned_to',
        'notes',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'area' => 'decimal:2',
        'budget' => 'decimal:2',
        'start_date' => 'date',
        'estimated_completion_date' => 'date',
        'actual_completion_date' => 'date',
    ];
    
    /**
     * Get the client that owns the project.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
    
    /**
     * Get the user assigned to the project.
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    
    /**
     * Get the invoices for the project.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
    
    /**
     * Get the site visits for the project.
     */
    public function siteVisits(): HasMany
    {
        return $this->hasMany(SiteVisit::class);
    }
    
    /**
     * Get the documents for the project.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
    
    /**
     * Get the tasks for the project.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
    
    /**
     * Get the daily reports for the project.
     */
    public function dailyReports(): HasMany
    {
        return $this->hasMany(DailyReport::class);
    }
    
    /**
     * Get the communication logs for the project.
     */
    public function communicationLogs(): HasMany
    {
        return $this->hasMany(CommunicationLog::class);
    }
    
    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('project_images')
            ->useDisk('public');
            
        $this->addMediaCollection('project_files')
            ->useDisk('public');
    }
}
