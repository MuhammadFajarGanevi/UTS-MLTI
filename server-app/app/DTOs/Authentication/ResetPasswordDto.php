<?php

namespace App\DTOs\Authentication;

use Spatie\LaravelData\Data;

class ResetPasswordDto extends Data
{
    public function __construct(
        readonly string $oldPassword,
        readonly string $newPassword,
        readonly string $confirmPassword,
    ){}
}
