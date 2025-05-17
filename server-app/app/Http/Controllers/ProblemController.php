<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DTOs\FilterDto;
use App\Services\ProblemService;
use App\DTOs\ApiResponseDto;
use App\DTOs\Problem\CreateProblemDto;
use App\DTOs\Problem\UpdateProblemDto;
use App\Services\ApiResponseService;

class ProblemController extends Controller
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
    public function create(CreateProblemDto $createProblemDto)
    {
        ProblemService::create($createProblemDto);
    }

    // Controller update Request Service
    public function update(UpdateProblemDto $updateProblemDto, int $id)
    {
        ProblemService::update($updateProblemDto, $id);
    }

    // Controller getAll & Search Request Service
    public function get(FilterDto $filterDto)
    {
        $data = ProblemService::getAll($filterDto);
        return ($this->response)(
            ApiResponseDto::from(["data" => $data])
        );
    }

    // Controller getId Request Service
    public function getId(int $id)
    {
        $data = ProblemService::getId($id);
        return ($this->response)(
            ApiResponseDto::from(["data" => $data])
        );
    }

    // Controller delete Request Service
    public function delete(int $id)
    {
        ProblemService::delete($id);
    }
}
