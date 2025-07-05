<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ClientPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users can view clients
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Client $client): bool
    {
        // All authenticated users can view clients
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Users with admin, designer, or pm roles can create clients
        return $user->hasRole('admin') || $user->hasRole('designer') || $user->hasRole('pm');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Client $client): bool
    {
        // Users with admin, designer, or pm roles can update clients
        return $user->hasRole('admin') || $user->hasRole('designer') || $user->hasRole('pm');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Client $client): bool
    {
        // Only admins can delete clients
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Client $client): bool
    {
        // Only admins can restore clients
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Client $client): bool
    {
        // Only admins can force delete clients
        return $user->hasRole('admin');
    }
    
    /**
     * Determine whether the user can access client projects.
     */
    public function viewProjects(User $user, Client $client): bool
    {
        // All authenticated users can view client projects
        return true;
    }
    
    /**
     * Determine whether the user can access client financials.
     */
    public function viewFinancials(User $user, Client $client): bool
    {
        // Only users with admin or pm roles can view client financials
        return $user->hasRole('admin') || $user->hasRole('pm');
    }
}
