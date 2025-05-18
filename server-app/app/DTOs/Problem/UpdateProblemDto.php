<?php

namespace App\DTOs\Problem;


use Spatie\LaravelData\Data;

class UpdateProblemDto extends Data
{
    public function __construct(
        readonly ?string $status,
        readonly ?string $comment,
    ) {
    }
}
