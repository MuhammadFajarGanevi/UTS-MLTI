<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class ApiResponseDto extends Data
{
    public function __construct(
        readonly mixed $data = null,
        readonly ?string $message,
        /** @var array<string> */
        readonly ?array $errors,
        readonly ?bool $status = true,
    ) {
    }
}
