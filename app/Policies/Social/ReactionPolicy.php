<?php

namespace App\Policies\Social;


use App\Models\Clients\User;
use App\Models\Social\Reaction;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReactionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any reactions.
     *
     * @param  \App\Models\Clients\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the reaction.
     *
     * @param  \App\Models\Clients\User  $user
     * @param  \App\Models\Social\Reaction  $reaction
     * @return mixed
     */
    public function view(User $user, Reaction $reaction)
    {
        //
    }

    /**
     * Determine whether the user can create reactions.
     *
     * @param  \App\Models\Clients\User  $user
     * @returSocial\n mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the reaction.
     *
     * @param  \App\Models\Clients\User  $user
     * @param  \App\Models\Social\Reaction  $reaction
     * @return mixed
     */
    public function update(User $user, Reaction $reaction)
    {
        return ($user->id === $reaction->user_id);
    }

    /**
     * Determine whether the user can delete the reaction.
     *
     * @param  \App\Models\Clients\User  $user
     * @param  \App\Models\Social\Reaction  $reaction
     * @return mixed
     */
    public function delete(User $user, Reaction $reaction)
    {
        return ($user->id === $reaction->user_id);
    }

    /**
     * Determine whether the user can restore the reaction.
     *
     * @param  \App\Models\Clients\User  $user
     * @param  \App\Models\Social\Reaction  $reaction
     * @return mixed
     */
    public function restore(User $user, Reaction $reaction)
    {
      return  ($user->id === $reaction->user_id);
    }

    /**
     * Determine whether the user can permanently delete the reaction.
     *
     * @param  \App\Models\Clients\User  $user
     * @param  \App\Models\Social\Reaction  $reaction
     * @return mixed
     */
    public function forceDelete(User $user, Reaction $reaction)
    {
        //
    }
}
