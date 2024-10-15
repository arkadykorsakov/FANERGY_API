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
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function register(RegisterRequest $request): User
    {
        return $this->userRepository->create($request->validated());
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
        $this->authenticate($user['email'], $data['current_password']);
        unset($data['current_password']);
        return $this->userRepository->update($user, $data);
    }

    public function deleteProfile(Request $request): bool
    {
        return $this->userRepository->delete($request->user());
    }

    public function deleteTokens(Request $request): int
    {
        return $this->userRepository->deleteTokens($request->user());
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
