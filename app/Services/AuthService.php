<?php

namespace App\Services;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Profile\UpdateAvatarRequest;
use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Http\Requests\Profile\UpdateRequest;
use App\Http\Requests\Profile\UpdateSocialRequest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Throwable;

class AuthService
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     * @throws Throwable
     */
    public function register(RegisterRequest $request): User
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->create($request->validated());
            $this->userRepository->addMedia($user, $request->file('avatar'), 'avatars');
            DB::commit();
            return $user;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $request): User
    {
        $data = $request->validated();
        return $this->authenticate($data['email'], $data['password']);
    }

    public function update(UpdateRequest|UpdateSocialRequest $request): User
    {
        return $this->userRepository->update($request->user(), $request->validated());
    }

    /**
     * @throws ValidationException
     */
    public function updatePassword(UpdatePasswordRequest $request): void
    {
        $data = $request->validated();
        $user = $request->user();
        $this->authenticate($user['email'], $data['current_password'], 'current_password', 'Неправильный пароль');
        $this->userRepository->update($user, $data);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws Throwable
     */
    public function updateAvatar(UpdateAvatarRequest $request): User
    {
        DB::beginTransaction();
        try {
            $user = $request->user();
            $this->userRepository->clearMediaCollection($user, 'avatars');
            $this->userRepository->addMedia($user, $request->file('avatar'), 'avatars');
            $user->refresh();
            DB::commit();
            return $user;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
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
    private function authenticate(string $email, string $password, string $fieldError = 'email', string $messageError = 'Неправильный логин или пароль.'): User
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                $fieldError => [$messageError],
            ]);
        }

        return $user;
    }
}
