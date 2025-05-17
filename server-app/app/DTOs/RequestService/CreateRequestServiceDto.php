<?php

namespace App\DTOs\RequestService;


use Spatie\LaravelData\Data;

class CreateRequestServiceDto extends Data
{
    public function __construct(
        readonly string $subject,
        readonly string $description,
        readonly int $requester_id,
        readonly array $category_id,
        readonly ?int $pic_id,
    ) {
    }
}
