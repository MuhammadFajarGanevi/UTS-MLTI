<?php

namespace App\Http\Controllers;

use App\DTOs\FilterDto;
use App\Services\IncidentService;
use App\DTOs\ApiResponseDto;
use App\DTOs\CreateIncidentDto;
use App\DTOs\UpdateIncidentDto;
use App\Services\ApiResponseService;

class IncidentController extends Controller
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

    // Controller create Incident
    public function create(CreateIncidentDto $createIncidentDto)
    {
        IncidentService::create($createIncidentDto);
    }

    // Controller update Incident
    public function update(UpdateIncidentDto $updateIncidentDto, int $id)
    {
        IncidentService::update($updateIncidentDto, $id);
    }

    // Controller getAll & Search Incident
    public function get(FilterDto $filterDto)
    {
        $data = IncidentService::getAll($filterDto);
        return ($this->response)(
            ApiResponseDto::from(["data" => $data])
        );
    }

    // Controller getId Incident
    public function getId(int $id)
    {
        $data = IncidentService::getId($id);
        return ($this->response)(
            ApiResponseDto::from(["data" => $data])
        );
    }

    // Controller delete Incident
    public function delete(int $id)
    {
        IncidentService::delete($id);
    }

}
