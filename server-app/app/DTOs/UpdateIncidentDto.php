<?php

namespace App\DTOs;

use App\Enums\IncidentStatus;
use App\Models\Incident;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Data;

class UpdateIncidentDto extends Data
{
    public function __construct(

        public ?int $resolver_id,
        public string $status,

    ) {
    }
}
