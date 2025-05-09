<?php

namespace App\Exceptions;

use Exception;
use App\Enums\ApiStatusEnum;

class ApiResponseException extends Exception
{
    protected array $data;
    protected ApiStatusEnum $status;

    public function __construct(array $data, ApiStatusEnum $status = ApiStatusEnum::BAD_REQUEST)
    {
        $this->data = $data;
        $this->status = $status;
        parent::__construct('', 0, null);
    }

    public function getAllMessage()
    {
        return $this->data;
    }

    public function getStatus()
    {
        return $this->status;
    }
}
