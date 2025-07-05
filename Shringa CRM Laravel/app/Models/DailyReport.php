<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class DailyReport extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'report_date',
        'project_id',
        'user_id',
        'work_completed',
        'challenges',
        'next_steps',
        'materials_used',
        'weather_conditions',
        'progress_percentage',
        'remarks',
        'client_updated',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'report_date' => 'date',
        'progress_percentage' => 'integer',
        'client_updated' => 'boolean',
    ];
    
    /**
     * Get the project associated with the daily report.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    
    /**
     * Get the user who created the daily report.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Update client that daily report has been shared
     */
    public function markAsClientUpdated(): void
    {
        $this->client_updated = true;
        $this->save();
    }
    
    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('daily_report_photos')
            ->useDisk('public');
    }
}
