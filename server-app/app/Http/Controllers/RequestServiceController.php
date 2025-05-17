<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DTOs\FilterDto;
use App\Services\RequestServices;
use App\DTOs\ApiResponseDto;
use App\DTOs\RequestService\CreateRequestServiceDto;
use App\DTOs\RequestService\UpdateRequestServiceDto;
use App\Services\ApiResponseService;

class RequestServiceController extends Controller
{
    protected ApiResponseService $response;

    /**
     * Create a new service instance.
     * @param \App\Services\ApiResponseService $response
     */
    public function __construct(ApiResponseService $response)
    {
        $this->response = $response;
    }

    // Controller create Request Service
    public function create(CreateRequestServiceDto $createRequestServiceDto)
    {
        RequestServices::create($createRequestServiceDto);
    }

    // Controller update Request Service
    public function update(UpdateRequestServiceDto $updateRequestServiceDto, int $id)
    {
        RequestServices::update($updateRequestServiceDto, $id);
    }

    // Controller getAll & Search Request Service
    public function get(FilterDto $filterDto)
    {
        $data = RequestServices::getAll($filterDto);
        return ($this->response)(
            ApiResponseDto::from(["data" => $data])
        );
    }

    // Controller getId Request Service
    public function getId(int $id)
    {
        $data = RequestServices::getId($id);
        return ($this->response)(
            ApiResponseDto::from(["data" => $data])
        );
    }

    // Controller delete Request Service
    public function delete(int $id)
    {
        RequestServices::delete($id);
    }
}
