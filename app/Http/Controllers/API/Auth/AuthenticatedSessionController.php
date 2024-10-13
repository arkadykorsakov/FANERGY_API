<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User\ProfileResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @throws ValidationException
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $user = $this->authService->login($request);

        return response()->json(['user' => ProfileResource::make($user), 'token' => $user->createToken(env('TOKEN'))->plainTextToken]);
    }

    public function destroy(Request $request): Response
    {
        $this->authService->deleteTokens($request);

        return response()->noContent();
    }
}
