<?php

namespace App\Providers;

use App\Policies\BillingPolicy;
use App\Policies\CommentPolicy;
use App\Policies\GoalPolicy;
use App\Policies\PostPolicy;
use App\Policies\UserBlocklistPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		if ($this->app->environment('local')) {
			$this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
			$this->app->register(TelescopeServiceProvider::class);
		}
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
		Gate::define('block-user', [UserBlocklistPolicy::class, 'blockUser']);
		Gate::define('unblock-user', [UserBlocklistPolicy::class, 'unblockUser']);
        Gate::define('update-billing', [BillingPolicy::class, 'update']);
        Gate::define('delete-billing', [BillingPolicy::class, 'delete']);
        Gate::define('update-comment', [CommentPolicy::class, 'update']);
        Gate::define('delete-comment', [CommentPolicy::class, 'delete']);
	}
}
