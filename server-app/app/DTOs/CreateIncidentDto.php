<?php

namespace App\DTOs;


use Spatie\LaravelData\Data;

class CreateIncidentDto extends Data
{
    public function __construct(
        readonly string $subject,
        readonly string $description,
        readonly array $category_id,
    ) {
    }
}
