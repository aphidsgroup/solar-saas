<?php

namespace App\Policies;

use App\Models\SiteVisit;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SiteVisitPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Allow all authenticated users to view site visits
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SiteVisit $siteVisit): bool
    {
        return true; // Allow all authenticated users to view site visit details
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Allow all authenticated users to create site visits
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SiteVisit $siteVisit): bool
    {
        // Allow users to update if they're admin or if they're assigned to the visit
        return $user->hasRole('admin') || $siteVisit->assigned_to === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SiteVisit $siteVisit): bool
    {
        // Only admin can delete site visits
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SiteVisit $siteVisit): bool
    {
        // Only admin can restore site visits
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SiteVisit $siteVisit): bool
    {
        // Only admin can force delete site visits
        return $user->hasRole('admin');
    }
}
