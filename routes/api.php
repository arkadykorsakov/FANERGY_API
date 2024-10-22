<?php

use App\Http\Controllers\Api\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\Auth\RegisteredUserController;
use App\Http\Controllers\Api\GoalController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UserSubscriptionController;
use App\Http\Controllers\Api\UserBlocklistController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureNotBlockedByNickname;

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
    Route::prefix('posts')->controller(PostController::class)->group(function () {
//        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{post}', 'show');
        Route::put('/{post}', 'update');
        Route::delete('/{post}', 'destroy');
        Route::post('/{post}/repost', 'addRepost');
        Route::delete('/{post}/repost', 'deleteRepost');
        Route::post('/{post}/like', 'toggleLike');
    });
    Route::prefix('tags')->controller(TagController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
    });
    Route::prefix('goals')->controller(GoalController::class)->group(function () {
//        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::put('/{goal}', 'update');
        Route::delete('/{goal}', 'destroy');
    });
    Route::prefix('users')->group(function () {
        Route::middleware('blocked.nickname')->controller(UserController::class)->group(function () {
            Route::get('/{nickname}', 'show');
            Route::get('/{nickname}/posts', 'posts');
            Route::get('/{nickname}/goals', 'goals');
        });
        Route::controller(UserSubscriptionController::class)->group(function () {
            Route::post('/{followingUser}/subscribe', 'subscribeToUser');
            Route::delete('/{followingUser}/unsubscribe', 'unsubscribeFromUser');
        });
        Route::controller(UserBlocklistController::class)->group(function () {
            Route::post('/{blockedUser}/block', 'blockUser');
            Route::delete('/{blockedUser}/unblock', 'unblockUser');
        });
    });
});
