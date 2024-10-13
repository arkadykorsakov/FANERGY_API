<?php

namespace App\Services;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Profile\UpdateRequest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterRequest $request): User
    {
        $data = $request->validated();
        return $this->userRepository->create($data)->refresh();
    }

    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $request): User
    {
        $data = $request->validated();
        return $this->authenticate($data['email'], $data['password']);
    }

    /**
     * @throws ValidationException
     */
    public function updateProfile(UpdateRequest $request): User
    {
        $data = $request->validated();
        $user = $request->user();
        $user = $this->authenticate($user['email'], $data['current_password']);
        return $this->userRepository->update($user, $data)->refresh();
    }

    public function deleteProfile(Request $request): bool
    {
        $user = $request->user();
        return $this->userRepository->delete($user);
    }

    public function deleteTokens(Request $request)
    {
        $user = $request->user();
        return $user->tokens()->delete();
    }

    /**
     * @throws ValidationException
     */
    private function authenticate(string $email, string $password): User
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Неправильный логин или пароль.'],
            ]);
        }

        return $user;
    }
}
