<?php

namespace App\Policies\Social;


use App\Models\Clients\User;
use App\Models\Social\Comment;
use http\Exception;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any comments.
     *
     * @param  \App\Models\Clients\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the comment.
     *
     * @param  \App\Models\Clients\User  $user
     * @param  \App\Models\Social\Comment  $comment
     * @return mixed
     */
    public function view(User $user, Comment $comment)
    {
        //
    }

    /**
     * Determine whether the user can create comments.
     *
     * @param  \App\Models\Clients\User  $user
     * @returSocial\n mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the comment.
     *
     * @param  \App\Models\Clients\User  $user
     * @param  \App\Models\Social\Comment  $comment
     * @return mixed
     */
    public function update(User $user, Comment $comment)
    {
        return ($user->id === $comment->user_id);
    }

    /**
     * Determine whether the user can delete the comment.
     *
     * @param  \App\Models\Clients\User  $user
     * @param  \App\Models\Social\Comment  $comment
     * @return mixed
     */
    public function delete(User $user, Comment $comment)
    {
        return ($user->id === $comment->user_id);
    }

    /**
     * Determine whether the user can restore the comment.
     *
     * @param  \App\Models\Clients\User  $user
     * @param  \App\Models\Social\Comment  $comment
     * @return mixed
     */
    public function restore(User $user, Comment $comment)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the comment.
     *
     * @param  \App\Models\Clients\User  $user
     * @param  \App\Models\Social\Comment  $comment
     * @return mixed
     */
    public function forceDelete(User $user, Comment $comment)
    {
        //
    }



}
