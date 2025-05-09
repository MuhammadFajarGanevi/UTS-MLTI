<?php

namespace App\DTOs\Authentication;

use Spatie\LaravelData\Data;

class LoginDto extends Data
{
    public function __construct(
        readonly string $email,
        readonly string $password,
        readonly string $isRememberMe,
    ){}

    public static function rules(): array
    {
        return [
            'email' => 'required|string',
            'password' => 'required|string',
            'isRememberMe' => 'boolean|default:false',
        ];
    }
}
