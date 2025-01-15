<?php

namespace App\Providers;

use App\Repositories\BillingRepository;
use App\Repositories\CommentRepository;
use App\Repositories\Interfaces\BillingRepositoryInterface;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\UserPostAccessRepositoryInterface;
use App\Repositories\Interfaces\UserSubscriptionRepositoryInterface;
use App\Repositories\SubscriptionLevelRepository;
use App\Repositories\GoalRepository;
use App\Repositories\Interfaces\SubscriptionLevelRepositoryInterface;
use App\Repositories\Interfaces\GoalRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\PostRepository;
use App\Repositories\TagRepository;
use App\Repositories\UserPostAccessRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserSubscriptionRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 */
	public function register(): void
	{
		$this->app->bind(UserRepositoryInterface::class, UserRepository::class);
		$this->app->bind(PostRepositoryInterface::class, PostRepository::class);
		$this->app->bind(TagRepositoryInterface::class, TagRepository::class);
		$this->app->bind(GoalRepositoryInterface::class, GoalRepository::class);
        $this->app->bind(SubscriptionLevelRepositoryInterface::class, SubscriptionLevelRepository::class);
        $this->app->bind(UserPostAccessRepositoryInterface::class, UserPostAccessRepository::class);
        $this->app->bind(UserSubscriptionRepositoryInterface::class, UserSubscriptionRepository::class);
        $this->app->bind(BillingRepositoryInterface::class, BillingRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
	}

	/**
	 * Bootstrap services.
	 */
	public function boot(): void
	{
		//
	}
}
