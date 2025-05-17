<?php

namespace App\DTOs\RequestService;


use Spatie\LaravelData\Data;

class UpdateRequestServiceDto extends Data
{
    public function __construct(
        readonly ?int $pic_id,
        readonly string $status,
        readonly ?string $comment,
    ) {
    }
}
