<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class UpdateIncidentDto extends Data
{
    public function __construct(

        public ?int $resolver_id,
        public readonly string $status,
        public ?string $comment,

    ) {
    }
}
