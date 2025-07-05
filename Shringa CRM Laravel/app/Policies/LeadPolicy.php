<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LeadPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users can view leads
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Lead $lead): bool
    {
        // Users can view leads assigned to them or if they're admin
        return $user->hasRole('admin') || $lead->assigned_to === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // All authenticated users can create leads
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Lead $lead): bool
    {
        // Users can update leads assigned to them or if they're admin
        return $user->hasRole('admin') || $lead->assigned_to === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Lead $lead): bool
    {
        // Only admins can delete leads
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Lead $lead): bool
    {
        // Only admins can restore leads
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Lead $lead): bool
    {
        // Only admins can force delete leads
        return $user->hasRole('admin');
    }
    
    /**
     * Determine whether the user can convert a lead to a client.
     */
    public function convertToClient(User $user, Lead $lead): bool
    {
        // Users can convert leads assigned to them or if they're admin
        return $user->hasRole('admin') || $lead->assigned_to === $user->id;
    }
}
