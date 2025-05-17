<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class FilterDto extends Data
{
    public function __construct(
        readonly ?int $page,
        readonly int $length,
        readonly ?string $search,
    ) {
    }
}