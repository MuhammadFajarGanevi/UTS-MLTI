<?php

namespace App\Services;

use App\Models\User;
use App\DTOs\Authentication\LoginDto;
use App\DTOs\Authentication\ResetPasswordDto;
use App\Enums\ApiStatusEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\ApiResponseException;

class AuthenticationService
{
    /**
     * Login the user using Sanctum and return an Api response DTO.
     *
     * @param LoginDto $loginDto
     */
    public static function login(LoginDto $loginDto)
    {
        $user = User::where('email', $loginDto->email)->first();

        if (!$user || !Hash::check($loginDto->password, $user->password)) {
            throw new ApiResponseException(
                [
                    "Invalid credentials.",
                ],
                ApiStatusEnum::UNAUTHORIZED
            );
        }

        // Generate token via Sanctum
        $token = $user->createToken(
            'personal_access_tokens',
            ['*'],
            $expiresAt = Carbon::now()->addMinutes(
                config("sanctum." . ($loginDto->is_remember_me ? "long_lived_expiration" : "short_lived_expiration"))
            )
        )->plainTextToken;

        return [
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]
        ];
    }

    /**
     * Reset the user password using the token.
     *
     * @param \App\DTOs\Authentication\ResetPasswordDto $resetPasswordDto
     */
    public static function resetPassword(ResetPasswordDto $resetPasswordDto)
    {
        $user = Auth::user();

        if (!$user || !Hash::check($resetPasswordDto->oldPassword, $user->password)) {
            throw new ApiResponseException(
                [
                    "Invalid credentials.",
                ],
                ApiStatusEnum::UNAUTHORIZED
            );
        }

        if (!Hash::check($resetPasswordDto->confirmPassword, $user->password)) {
            throw new ApiResponseException(
                [
                    "Passwords do not match.",
                ],
                ApiStatusEnum::UNPROCESSABLE_ENTITY
            );
        }

        $user->password = Hash::make($resetPasswordDto->newPassword);
        $user->save();
    }

    /**
     * Refresh the user token.
     *
     * @param \Illuminate\Http\Request $request
     */
    public static function refreshToken()
    {
        $user = Auth::user();
        $token = $user->createToken(
            'personal_access_tokens',
            ['*'],
            $expiresAt = Carbon::now()->addMinutes(
                config("sanctum.long_lived_expiration")
            )
        )->plainTextToken;

        return [
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'expires_at' => $expiresAt->toDateTimeString()
        ];
    }

    public static function logout()
    {
        Auth::logout();
    }

    public static function getUser()
    {
        $user = Auth::user();

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
    }

    public static function start()
    {
        User::create([
            'name' => "admin",
            'email' => "admin@example.com",
            'password' => Hash::make('123456'),
        ]);
    }
}
