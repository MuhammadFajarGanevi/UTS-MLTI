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
    public function updateStatus(UpdateRequestServiceDto $updateRequestServiceDto, int $id)
    {
        RequestServices::updateStatus($updateRequestServiceDto, $id);
    }

    public function updateWorker(UpdateRequestServiceDto $updateRequestServiceDto, int $id)
    {
        RequestServices::updateWorker($updateRequestServiceDto, $id);
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

    // Get Category
    public function getCategory()
    {
        $data = RequestServices::getCategory();

        return ($this->response)(ApiResponseDto::from($data));
    }

    // Controller delete Request Service
    public function delete(int $id)
    {
        RequestServices::delete($id);
    }
}
