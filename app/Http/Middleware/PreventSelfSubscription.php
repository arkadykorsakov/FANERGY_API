<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventSelfSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = $request->user()->id;
        $authorId = $request->route('author')->id;

        if ($userId === $authorId) {
            return response()->json([
                'message' => 'Conflict.',
            ], Response::HTTP_CONFLICT);
        }

        return $next($request);
    }
}
