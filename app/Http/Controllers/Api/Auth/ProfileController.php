<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateRequest;
use App\Http\Resources\User\ProfileResource;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{


    public function __construct(private AuthService $authService)
    {
    }

    public function show(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(['user' => ProfileResource::make($request->user())]);
    }

    /**
     * @throws ValidationException
     */
    public function update(UpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = $this->authService->updateProfile($request);

        return response()->json(['user' => ProfileResource::make($user)]);
    }
}
