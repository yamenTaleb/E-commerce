<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Review;
use Illuminate\Auth\Access\Response;

class ReviewPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, review $review): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Review $review): Response
    {
        return $user->id === $review->user_id
            ? Response::allow()
            : Response::deny('You do not own this review.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, review $review): Response
    {
        return ($user->id === $review->user_id
            or $user->role === 'admin')
            ? Response::allow()
            : Response::deny('You do not own this review.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, review $review): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, review $review): bool
    {
        return false;
    }
}
