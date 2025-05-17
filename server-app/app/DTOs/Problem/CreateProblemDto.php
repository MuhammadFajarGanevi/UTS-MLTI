<?php

namespace App\DTOs\Problem;


use Spatie\LaravelData\Data;

class CreateProblemDto extends Data
{
    public function __construct(
        readonly string $subject,
        readonly string $description,
        readonly int $reporter_id,
        readonly array $category_id,
        readonly ?int $pic_id,
    ) {
    }
}
