<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
        $middleware->alias([
            'ensure.not.blocked.nickname' => \App\Http\Middleware\EnsureNotBlockedByNickname::class,
            'ensure.not.blocked.author' => \App\Http\Middleware\EnsureNotBlockedByAuthor::class,
            'prevent.self.subscription' => \App\Http\Middleware\PreventSelfSubscription::class,
            'prevent.self.block' => \App\Http\Middleware\PreventSelfBlock::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/users/*/subscribe') || $request->is('api/users/*/unsubscribe')) {
                return response()->json([
                    'message' => 'Такого пользователя не существует.',
                    'errors' => ['author_id' => ['Такого пользователя не существует']],
                    'e'=>$e->getMessage()
                ], 422);
            }
            if ($request->is('api/users/*/block') || $request->is('api/users/*/unblock')) {
                return response()->json([
                    'message' => 'Такого пользователя не существует.',
                    'errors' => ['blocked_user_id' => ['Такого пользователя не существует']]
                ], 422);
            }
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Not found.'
                ], 404);
            }
        });
        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Forbidden.'
                ], 403);
            }
        });
        $exceptions->render(function (ConflictHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Conflict.',
                ], 409);
            }
        });
        $exceptions->render(function (HttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Bad Request.'
                ], 400);
            }
        });
    })->create();
