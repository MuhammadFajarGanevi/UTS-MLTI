<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DTOs\Authentication\LoginDto;
use App\DTOs\Authentication\ResetPasswordDto;
use App\DTOs\ApiResponseDto;
use App\Enums\ApiStatusEnum;
use App\Services\ApiResponseService;
use App\Services\AuthenticationService;

class AuthenticationController extends Controller
{
    protected ApiResponseService $response;

    /**
     * Create a new service instance.
     * @param \App\Infrastructure\Services\ApiResponseService $response
     */
    public function __construct(ApiResponseService $response)
    {
        $this->response = $response;
    }

    /**
     * Login the user.
     * @param \App\DTOs\Authentication\LoginDto $loginDto
     * @param \Illuminate\Http\Request $request
     * @return \App\DTOs\ApiResponseDto
     */
    public function login(LoginDto $loginDto, Request $request)
    {
        $token = AuthenticationService::login($loginDto);

        return ($this->response)(ApiResponseDto::from(["data" => $token]));
    }

    /**
     * Reset the user password.
     * @param \App\DTOs\Authentication\ResetPasswordDto $resetPasswordDto
     * @param \Illuminate\Http\Request $request
     * @return \App\DTOs\ApiResponseDto
     */
    public function resetPassword(ResetPasswordDto $resetPasswordDto, Request $request)
    {
        AuthenticationService::resetPassword($resetPasswordDto);
    }

    /**
    * Refresh the user token.
    * @param \Illuminate\Http\Request $request
    * @return \App\DTOs\ApiResponseDto
    */
    public function refreshToken(Request $request)
    {
        $token = AuthenticationService::refreshToken();

        return ($this->response)(ApiResponseDto::from($token));
    }
}
