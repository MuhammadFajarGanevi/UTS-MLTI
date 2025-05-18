<?php

namespace App\DTOs\Problem;


use Spatie\LaravelData\Data;

class CreateProblemDto extends Data
{
    public function __construct(
        readonly string $subject,
        readonly string $description,
        readonly array $category_id,
    ) {
    }
}
