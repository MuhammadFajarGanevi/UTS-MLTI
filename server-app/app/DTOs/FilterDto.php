<?php

namespace App\DTOs;

use App\Enums\IncidentStatus;
use App\Models\Incident;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Data;

class FilterDto extends Data
{
    public function __construct(
        public ?int $page,
        public int $length,
        public ?string $search,
    ) {
    }
}