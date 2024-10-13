<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateRequest;
use App\Http\Resources\User\ProfileResource;
use App\Services\AuthService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function show(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(['user' => ProfileResource::make($request->user())]);
    }

    public function update(UpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = $this->authService->updateProfile($request);

        return response()->json(['user' => ProfileResource::make($user)]);
    }
}
