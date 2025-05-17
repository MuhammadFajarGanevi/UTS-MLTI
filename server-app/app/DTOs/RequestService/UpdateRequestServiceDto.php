<?php

namespace App\DTOs\RequestService;


use Spatie\LaravelData\Data;

class UpdateRequestServiceDto extends Data
{
    public function __construct(
        readonly ?string $status,
        readonly ?string $comment,
    ) {
    }
}
