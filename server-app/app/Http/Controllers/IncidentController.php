<?php

namespace App\Http\Controllers;

use App\DTOs\FilterDto;
use App\Services\IncidentService;
use Illuminate\Http\Request;
use App\DTOs\ApiResponseDto;
use App\DTOs\CreateIncidentDto;
use App\DTOs\UpdateIncidentDto;
use App\Enums\ApiStatusEnum;
use App\Services\ApiResponseService;
use App\Services\AuthenticationService;
use GuzzleHttp\Promise\Create;
use function Laravel\Prompts\error;

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

    public function create(CreateIncidentDto $createIncidentDto)
    {
        IncidentService::create($createIncidentDto);
    }

    public function update(UpdateIncidentDto $updateIncidentDto, int $id)
    {
        IncidentService::update($updateIncidentDto, $id);
    }

    public function get(FilterDto $filterDto)
    {
        $data = IncidentService::getAll($filterDto);
        return ($this->response)(ApiResponseDto::from(["data" => $data]));
    }

    public function getId(int $id)
    {
        $data = IncidentService::getId($id);
    }

    public function delete(int $id)
    {
        IncidentService::delete($id);
    }

}
