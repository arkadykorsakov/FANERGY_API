<?php

namespace App\Providers;

use App\Policies\GoalPolicy;
use App\Policies\PostPolicy;
use App\Policies\UserBlocklistPolicy;
use App\Policies\UserSubscriptionPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('update-post', [PostPolicy::class, 'update']);
        Gate::define('delete-post', [PostPolicy::class, 'delete']);
        Gate::define('update-goal', [GoalPolicy::class, 'update']);
        Gate::define('delete-goal', [GoalPolicy::class, 'delete']);
        Gate::define('add-repost-post', [PostPolicy::class, 'addRepost']);
        Gate::define('delete-repost-post', [PostPolicy::class, 'deleteRepost']);
        Gate::define('subscribe-user', [UserSubscriptionPolicy::class, 'subscribeToUser']);
        Gate::define('unsubscribe-user', [UserSubscriptionPolicy::class, 'unsubscribeFromUser']);
        Gate::define('block-user', [UserBlocklistPolicy::class, 'blockUser']);
        Gate::define('unblock-user', [UserBlocklistPolicy::class, 'unblockUser']);
    }
}
