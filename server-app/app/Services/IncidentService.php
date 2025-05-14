<?php

namespace App\Services;

use App\Models\Incident;
use App\DTOs\CreateIncidentDto;
use App\DTOs\FilterDto;
use Illuminate\Http\Request;
use App\DTOs\ApiResponseDto;
use App\DTOs\UpdateIncidentDto;
use App\Enums\ApiStatusEnum;
use App\Enums\IncidentStatus;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
class IncidentService
{
    protected Request $request;
    /**
     * Create a new service instance
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
     * @return void
     */

    //  Function Post
    public static function create(CreateIncidentDto $createIncidentDto)
    {
        Incident::create([
            'subject' => $createIncidentDto->subject,
            'description' => $createIncidentDto->description,
            'reporter_id' => $createIncidentDto->reporter_id,
            'category_id' => $createIncidentDto->category_id,
            'status' => IncidentStatus::SUBMITTED
        ]);
    }

    // Function Update with parameter id
    public static function update(UpdateIncidentDto $updateIncidentDto, int $id)
    {

        // Validasi apakah status ada dalam enum
        $validStatuses = array_column(IncidentStatus::cases(), 'value');

        if (!in_array($updateIncidentDto->status, $validStatuses)) {
            throw new UnprocessableEntityHttpException('error entity');
        }


        // Ambil data incident
        $incident = Incident::findOrFail($id); // agar

        $incident->update([
            'resolver_id' => $updateIncidentDto->resolver_id,
            'status' => $updateIncidentDto->status,
            'updated_at' => now(),
        ]);
    }

    // Function getAll
    public static function getAll(FilterDto $filterDto)
    {
        $incidents = Incident::paginate($filterDto->length);

        // Format respons
        return [
            'current_page' => $incidents->currentPage(),
            'total_data' => $incidents->total(),
            'total_page' => $incidents->lastPage(),
            'data' => $incidents->items()
        ];
    }

    // Function get with Id
    public static function getId(int $id)
    {
        $incident = Incident::findOrFail($id);
        return CreateIncidentDto::from($incident);
    }

    // Function softDelete
    public static function delete(int $id)
    {
        $incident = Incident::findOrFail($id);
        $incident->delete();
    }
}

