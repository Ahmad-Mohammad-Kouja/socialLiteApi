<?php

namespace App\Policies\Social;


use App\Models\Clients\User;
use App\Models\Social\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any posts.
     *
     * @param  \App\Models\Clients\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the post.
     *
     * @param  \App\Models\Clients\User  $user
     * @param  \App\Models\Social\Post  $post
     * @return mixed
     */
    public function view(User $user, Post $post)
    {
        //
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  \App\Models\Clients\User  $user
     * @returSocial\n mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  \App\Models\Clients\User  $user
     * @param  \App\Models\Social\Post  $post
     * @return mixed
     */
    public function update(User $user, Post $post)
    {
        return ($user->id === $post->user_id);
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  \App\Models\Clients\User  $user
     * @param  \App\Models\Social\Post  $post
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
        return ($user->id === $post->user_id);
    }

    /**
     * Determine whether the user can restore the post.
     *
     * @param  \App\Models\Clients\User  $user
     * @param  \App\Models\Social\Post  $post
     * @return mixed
     */
    public function restore(User $user, Post $post)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the post.
     *
     * @param  \App\Models\Clients\User  $user
     * @param  \App\Models\Social\Post  $post
     * @return mixed
     */
    public function forceDelete(User $user, Post $post)
    {
        //
    }
}
