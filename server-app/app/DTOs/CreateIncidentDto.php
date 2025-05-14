<?php

namespace App\DTOs;

use App\Enums\IncidentStatus;
use App\Models\Incident;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Data;

class CreateIncidentDto extends Data
{
    public function __construct(

        public string $subject,
        public string $description,
        public int $reporter_id,
        public int $category_id,
        public ?int $resolver_id,
    ) {
    }
}
