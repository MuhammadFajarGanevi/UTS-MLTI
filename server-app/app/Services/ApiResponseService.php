<?php

namespace App\Services;

use App\DTOs\ApiResponseDto;
use App\Enums\ApiStatusEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiResponseService
{
    protected Request $request;

    /**
     * Create a new service instance.
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * Generate a JSON response.
     *
     * @param APIResponseDto $response
     * @param APIStatusEnum $status
     * @return JsonResponse
     */
    public function __invoke(ApiResponseDto $response, ?ApiStatusEnum $status = ApiStatusEnum::SUCCESS): JsonResponse
    {
        $result = [
            "status" => $response->status ?? true,
            "message" => $response->message ?? $status->getMessage(),
        ];

        if (!empty($response->data)) {
            $result['data'] = $response->data;
        }

        if (!empty($response->errors)) {
            $result['errors'] = $response->errors;
        }

        return response()->json([
            $result
        ])->setStatusCode($status->value);
    }
}
