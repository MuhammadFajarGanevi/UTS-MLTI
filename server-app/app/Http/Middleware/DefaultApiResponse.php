<?php

namespace App\Http\Middleware;

use App\DTOs\ApiResponseDto;
use App\Enums\ApiStatusEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\ApiResponseService;

class DefaultApiResponse
{
    protected ApiResponseService $response;

    /**
     * Create a new middleware instance.
     *
     * @param  \App\Services\ApiResponseService  $apiResponseService
     */
    public function __construct(ApiResponseService $apiResponseService)
    {
        $this->response = $apiResponseService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        // If controller method returned void (null content)
        if ($response->getContent() === '' && $response->getStatusCode() === 200) {
            $method = strtoupper($request->getMethod());

            switch ($method) {
                case 'POST':
                    return ($this->response)(ApiResponseDto::from(), ApiStatusEnum::CREATED);
                case 'PUT':
                case 'PATCH':
                    return ($this->response)(ApiResponseDto::from(), ApiStatusEnum::SUCCESS);
                case 'DELETE':
                    return ($this->response)(ApiResponseDto::from(), ApiStatusEnum::ACCEPTED);
            }
        }

        return $response;
    }
}
