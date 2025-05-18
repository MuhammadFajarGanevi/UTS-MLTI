<?php

namespace App\Services;

use App\Models\CategoryIncident;
use App\Models\Incident;
use App\DTOs\CreateIncidentDto;
use App\DTOs\FilterDto;
use Illuminate\Http\Request;
use App\DTOs\ApiResponseDto;
use App\DTOs\UpdateIncidentDto;
use App\Enums\ApiStatusEnum;
use App\Enums\IncidentStatus;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\ApiResponseException;
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
    public static function create(CreateIncidentDto $createIncidentDto): void
    {
        $user = Auth::user();

        if (!in_array($user->name, ['User', 'Administrator'])) {
            throw new ApiResponseException(['You are not authorized'], ApiStatusEnum::UNAUTHORIZED);
        }
        // validate
        if (!$createIncidentDto->category_id) {
            throw new UnprocessableEntityHttpException('Error!!! Either reporter or category must be specified');
        }
        // Buat incident
        $incident = Incident::create([
            'subject' => $createIncidentDto->subject,
            'description' => $createIncidentDto->description,
            'reporter_id' => $user->id,
            'status' => IncidentStatus::SUBMITTED,
        ]);

        // Hubungkan ke kategori (dari relasi many-to-many)
        $incident->categories()->attach($createIncidentDto->category_id, [
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    // Function Update with parameter id
    public static function updateStatus(UpdateIncidentDto $updateIncidentDto, int $id)
    {
        $user = Auth::user();
        if ($user->name !== 'Administrator') {
            throw new ApiResponseException(['You are not authorized'], ApiStatusEnum::UNAUTHORIZED);
        }
        // Validasi apakah status ada dalam enum
        $validStatuses = array_column(IncidentStatus::cases(), 'value');
        if (!in_array($updateIncidentDto->status, $validStatuses)) {
            throw new UnprocessableEntityHttpException('error entity');
        }
        // Ambil data incident
        $incident = Incident::findOrFail($id); // agar

        // Update data lainnya
        $incident->status = $updateIncidentDto->status;
        $incident->updated_at = now();

        $incident->save();
    }

    // Update Worker Incident
    public static function updateWorker(UpdateIncidentDto $updateIncidentDto, int $id)
    {
        $user = Auth::user();
        if ($user->name !== 'Worker') {
            throw new ApiResponseException(['You are not authorized'], ApiStatusEnum::UNAUTHORIZED);
        }

        // Ambil data incident
        $incident = Incident::findOrFail($id); // agar

        // Update data lainnya
        $incident->resolver_id = $user->id;
        $incident->comment = $updateIncidentDto->comment;
        $incident->updated_at = now();
        $incident->save();
    }

    // Function getAll
    public static function getAll(FilterDto $filterDto)
    {
        $query = Incident::with(['reporter', 'resolver', 'categories']);

        if ($filterDto->search) {
            $query->where('subject', 'like', '%' . $filterDto->search . '%');
        }

        $incidents = $query->paginate($filterDto->length);

        $transformed = $incidents->getCollection()->map(function ($incident) {
            return [
                'id' => $incident->id,
                'subject' => $incident->subject,
                'description' => $incident->description,
                'status' => $incident->status,
                'comment' => $incident->comment,
                'created_at' => $incident->created_at,

                'reporter' => [
                    'id' => $incident->reporter?->id,
                    'name' => $incident->reporter?->name,
                ],
                'resolver' => [
                    'id' => $incident->resolver?->id,
                    'name' => $incident->resolver?->name,
                ],
                'categories' => $incident->categories->sortBy('id')->values()->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                    ];
                })->values(),
            ];
        });

        $incidents->setCollection($transformed);

        if ($incidents->total() === 0) {
            abort(404, 'Data not found');
        }

        return [
            'current_page' => $incidents->currentPage(),
            'total_data' => $incidents->total(),
            'total_page' => $incidents->lastPage(),
            'data' => $incidents->items(),
        ];
    }


    // Function get all Categoryy
    public static function getCategory()
    {
        $query = CategoryIncident::all();

        return ['data' => $query];
    }

    // Function get with Id
    public static function getId(int $id)
    {
        $incident = Incident::with(['reporter', 'resolver', 'categories'])->findOrFail($id);

        return [
            'data' => [
                'id' => $incident->id,
                'subject' => $incident->subject,
                'description' => $incident->description,
                'status' => $incident->status,
                'comment' => $incident->comment,
                'created_at' => $incident->created_at,

                'reporter' => [
                    'id' => $incident->reporter?->id,
                    'name' => $incident->reporter?->name,
                ],
                'resolver' => [
                    'id' => $incident->resolver?->id ?? 'null',
                    'name' => $incident->resolver?->name ?? 'null',
                ],
                'categories' => $incident->categories->sortBy('id')->values()->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                    ];
                })
            ],
        ];
    }

    // Function softDelete
    public static function delete(int $id)
    {
        $user = Auth::user();
        if ($user->name !== 'Administrator') {
            throw new ApiResponseException(['ur not authorized'], ApiStatusEnum::UNAUTHORIZED);
        }

        $incident = Incident::findOrFail($id);
        $incident->delete();
        $incident->categories()->detach();
    }
}

