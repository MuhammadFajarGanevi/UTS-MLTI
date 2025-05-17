<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class UpdateIncidentDto extends Data
{
    public function __construct(

        readonly ?string $status,
        readonly ?string $comment,

    ) {
    }
}
