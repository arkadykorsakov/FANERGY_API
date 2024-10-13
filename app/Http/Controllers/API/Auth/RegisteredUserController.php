<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\ProfileResource;
use App\Services\AuthService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RegisteredUserController extends Controller
{
	private AuthService $authService;

	public function __construct(AuthService $authService)
	{
		$this->authService = $authService;
	}

	public function store(RegisterRequest $request): \Illuminate\Http\JsonResponse
	{
		$user = $this->authService->register($request);

		event(new Registered($user));

		return response()->json([
			'user' => ProfileResource::make($user),
			'token' => $user->createToken(env('TOKEN'))->plainTextToken,
		], Response::HTTP_CREATED);
	}

	public function destroy(Request $request): Response
	{
		$this->authService->deleteProfile($request);

		return response()->noContent();
	}
}
