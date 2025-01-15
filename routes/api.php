<?php

use App\Http\Controllers\Api\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\Auth\RegisteredUserController;
use App\Http\Controllers\Api\BillingController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\GoalController;
use App\Http\Controllers\Api\MeDataController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UserSubscriptionController;
use App\Http\Controllers\Api\UserBlocklistController;
use App\Http\Controllers\Api\UserPostAccessController;
use App\Http\Controllers\Api\SubscriptionLevelController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [ProfileController::class, 'show']);
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
    Route::put('/update-profile', [ProfileController::class, 'updateProfile']);
    Route::put('/update-social-links', [ProfileController::class, 'updateSocialLinks']);
    Route::put('/update-password', [ProfileController::class, 'updatePassword']);
    Route::put('/update-avatar', [ProfileController::class, 'updateAvatar']);
    Route::delete('/delete-account', [RegisteredUserController::class, 'destroy']);

    Route::prefix('posts')->group(function () {
        Route::controller(PostController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/{post}', 'show');
            Route::put('/{post}', 'update');
            Route::put('/{post}/subscription_level', 'updateSubscriptionLevel');
            Route::delete('/{post}', 'destroy');
            Route::post('/{post}/repost', 'addRepost');
            Route::delete('/{post}/repost', 'deleteRepost');
            Route::post('/{post}/like', 'toggleLike');
        });
        Route::controller(UserPostAccessController::class)->group(function () {
            Route::post('/{post}/buy_show_access', 'buyShowAccessForPost');
        });
        Route::controller(CommentController::class)->group(function () {
            Route::post('/{post}/add-comment', 'store');
        });
    });


    Route::prefix('tags')->controller(TagController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
    });
    Route::prefix('goals')->controller(GoalController::class)->group(function () {
        Route::post('/', 'store');
        Route::put('/{goal}', 'update');
        Route::delete('/{goal}', 'destroy');
    });
    Route::prefix('users')->group(function () {
        Route::middleware('ensure.not.blocked.nickname')->controller(UserController::class)->group(function () {
            Route::get('/{nickname}', 'show');
            Route::get('/{nickname}/posts', 'posts');
            Route::get('/{nickname}/goals', 'goals');
        });
        Route::middleware(['prevent.self.subscription', 'ensure.not.blocked.author'])->controller(UserSubscriptionController::class)->group(function () {
            Route::post('/{author}/subscribe', 'subscribeToUser');
            Route::post('/{author}/buy_level', 'buyLevelSubscriptionForUser');
            Route::put('/{author}/upgrade_level', 'upgradeSubscriptionLevelForUser');
            Route::put('/{author}/prolong_level', 'prolongSubscriptionLevelForUser');
            Route::delete('/{author}/unsubscribe', 'unsubscribeFromUser');
        });

        Route::middleware('prevent.self.block')->controller(UserBlocklistController::class)->group(function () {
            Route::post('/{blockedUser}/block', 'blockUser');
            Route::delete('/{blockedUser}/unblock', 'unblockUser');
        });
    });

    Route::prefix('subscribes')->group(function () {
        Route::controller(UserSubscriptionController::class)->group(function () {
            Route::put('/{subscription}', 'updateSubscription');
        });
    });

    Route::prefix('subscription_levels')->group(function () {
        Route::controller(SubscriptionLevelController::class)->group(function () {
            Route::post('/', 'store');
            Route::put('/{subscriptionLevel}', 'update');
            Route::delete('/{subscriptionLevel}', 'destroy');
        });
    });

    Route::prefix('billings')->group(function () {
        Route::get('/me', [MeDataController::class, 'billings']);
        Route::controller(BillingController::class)->group(function () {
            Route::post('/', 'store');
            Route::put('/{billing}/set-main', 'setMain');
            Route::delete('/{billing}', 'destroy');
        });
    });

    Route::prefix('comments')->group(function () {
        Route::controller(CommentController::class)->group(function () {
            Route::put('/{comment}', 'update');
            Route::delete('/{comment}', 'destroy');
        });
    });
});
