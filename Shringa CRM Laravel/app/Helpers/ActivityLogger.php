<?php

namespace App\Helpers;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    /**
     * Log an activity.
     *
     * @param string $type
     * @param string $description
     * @param array $relations
     * @param array $metadata
     * @return Activity
     */
    public static function log(
        string $type, 
        string $description, 
        array $relations = [], 
        array $metadata = []
    ): Activity {
        $data = [
            'type' => $type,
            'description' => $description,
            'user_id' => Auth::id(),
            'metadata' => $metadata,
        ];
        
        // Add relation IDs if provided
        if (isset($relations['lead_id'])) {
            $data['lead_id'] = $relations['lead_id'];
        }
        
        if (isset($relations['client_id'])) {
            $data['client_id'] = $relations['client_id'];
        }
        
        if (isset($relations['project_id'])) {
            $data['project_id'] = $relations['project_id'];
        }
        
        if (isset($relations['task_id'])) {
            $data['task_id'] = $relations['task_id'];
        }
        
        return Activity::create($data);
    }
} 