<?php

namespace App\Providers;


use App\Models\Social\Comment;
use App\Models\Social\Post;
use App\Models\Social\Reaction;
use App\Policies\Social\CommentPolicy;
use App\Policies\Social\PostPolicy;
use App\Policies\Social\ReactionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy'
        Comment::class => CommentPolicy::class,
        Reaction::class => ReactionPolicy::class,
        Post::class => PostPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
        //
    }
}
