<?php

namespace App\DTOs\Authentication;

use Spatie\LaravelData\Data;

class LoginDto extends Data
{
    public function __construct(
        readonly string $email,
        readonly string $password,
        readonly bool $is_remember_me,
    ){}
}
