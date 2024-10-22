<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

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
            'blocked.nickname' => \App\Http\Middleware\EnsureNotBlockedByNickname::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/users/*/subscribe') || $request->is('api/users/*/unsubscribe')) {
                return response()->json([
                    'message' => 'Такого пользователя не существует.',
                    'errors' => ['follower_id' => ['Такого пользователя не существует']]
                ], 422);
            }
            if ($request->is('api/users/*/block') || $request->is('api/users/*/unblock')) {
                return response()->json([
                    'message' => 'Такого пользователя не существует.',
                    'errors' => ['follower_id' => ['Такого пользователя не существует']]
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
    })->create();
