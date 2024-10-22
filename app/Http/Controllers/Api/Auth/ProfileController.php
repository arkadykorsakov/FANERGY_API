<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateAvatarRequest;
use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Http\Requests\Profile\UpdateRequest;
use App\Http\Requests\Profile\UpdateSocialRequest;
use App\Http\Resources\User\ProfileResource;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Throwable;

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
     * @throws Throwable
     */
    public function updateProfile(UpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = $this->authService->update($request);
        return response()->json(['user' => ProfileResource::make($user)]);
    }

    public function updateSocialLinks(UpdateSocialRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = $this->authService->update($request);
        return response()->json(['user' => ProfileResource::make($user)]);
    }

    /**
     * @throws ValidationException
     */
    public function updatePassword(UpdatePasswordRequest $request): \Illuminate\Http\Response
    {
        $this->authService->updatePassword($request);
        return response()->noContent();
    }

    /**
     * @throws Throwable
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function updateAvatar(UpdateAvatarRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = $this->authService->updateAvatar($request);
        return response()->json(['user' => ProfileResource::make($user)]);
    }
}
