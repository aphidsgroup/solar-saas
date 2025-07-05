<?php

namespace App\Policies;

use App\Models\CommunicationLog;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommunicationLogPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Allow all authenticated users to view communication logs index
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CommunicationLog $communicationLog): bool
    {
        // Users can view communication logs if they created them or are admin
        return $user->hasRole('admin') || $communicationLog->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Allow all authenticated users to create communication logs
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CommunicationLog $communicationLog): bool
    {
        // Only the user who created the log or admin can update it
        return $user->hasRole('admin') || $communicationLog->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CommunicationLog $communicationLog): bool
    {
        // Only the user who created the log or admin can delete it
        return $user->hasRole('admin') || $communicationLog->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CommunicationLog $communicationLog): bool
    {
        // Only admin can restore communication logs
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CommunicationLog $communicationLog): bool
    {
        // Only admin can force delete communication logs
        return $user->hasRole('admin');
    }
}
