<?php

use App\Http\Controllers\Api\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\Auth\RegisteredUserController;
use App\Http\Controllers\Api\GoalController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [ProfileController::class, 'show']);
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
    Route::put('/update-account', [ProfileController::class, 'update']);
    Route::delete('/delete-account', [RegisteredUserController::class, 'destroy']);
    Route::prefix('posts')->controller(PostController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::put('/{post}', 'update');
        Route::delete('/{post}', 'destroy');
    });
    Route::prefix('tags')->controller(TagController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
    });
    Route::prefix('goals')->controller(GoalController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::put('/{goal}', 'update');
        Route::delete('/{goal}', 'destroy');
    });
    Route::prefix('users')->controller(UserController::class)->group(function () {
        Route::get('/{nickname}/posts', 'posts');
        Route::get('/{nickname}/goals', 'goals');
    });
});
