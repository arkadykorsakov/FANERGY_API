<?php

namespace App\Providers;

use App\Repositories\Interfaces\UserPostAccessRepositoryInterface;
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
	}

	/**
	 * Bootstrap services.
	 */
	public function boot(): void
	{
		//
	}
}
