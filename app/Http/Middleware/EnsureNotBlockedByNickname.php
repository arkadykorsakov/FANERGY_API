<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureNotBlockedByNickname
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::where('nickname', $request->route('nickname'))->firstOrFail();
        if ($user->isMeBlockedByUser) {
            return response()->json( ['message'=>'Forbidden.'], 403,);
        }
        return $next($request);
    }
}
