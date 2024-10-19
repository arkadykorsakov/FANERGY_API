<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\ProfileResource;
use App\Services\AuthService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Throwable;

class RegisteredUserController extends Controller
{
	public function __construct(private AuthService $authService)
	{
	}

    /**
     * @throws Throwable
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(RegisterRequest $request): \Illuminate\Http\JsonResponse
	{
		$user = $this->authService->register($request);

		event(new Registered($user));

		return response()->json([
			'user' => ProfileResource::make($user),
			'token' => $user->createToken('TOKEN')->plainTextToken,
		], Response::HTTP_CREATED);
	}

	public function destroy(Request $request): Response
	{
		$this->authService->deleteProfile($request);

		return response()->noContent();
	}
}
