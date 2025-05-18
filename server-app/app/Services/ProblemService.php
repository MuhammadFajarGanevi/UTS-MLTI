<?php

namespace App\Services;

use App\Models\Problem;
use App\DTOs\Problem\CreateProblemDto;
use App\DTOs\Problem\UpdateProblemDto;
use App\DTOs\FilterDto;
use App\DTOs\ApiResponseDto;
use App\Enums\ApiStatusEnum;
use App\Enums\ProblemStatusEnum;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use App\Exceptions\ApiResponseException;
use App\Models\CategoryProblem;

class ProblemService
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
    public static function create(CreateProblemDto $createProblemDto): void
    {
        $user = Auth::user();
        // validate
        if (!in_array($user->name, ['User', 'Administrator'])) {
            throw new ApiResponseException(['You are not authorized'], ApiStatusEnum::UNAUTHORIZED);

        }
        if (!$createProblemDto->category_id) {
            throw new UnprocessableEntityHttpException('Error!!! Either reporter or category must be specified');
        }

        // Buat incident
        $Problem = Problem::create([
            'subject' => $createProblemDto->subject,
            'description' => $createProblemDto->description,
            'reporter_id' => $user->id,
            'status' => ProblemStatusEnum::OPENED,
        ]);

        // Hubungkan ke kategori (dari relasi many-to-many)
        $Problem->categories()->attach($createProblemDto->category_id, [
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    // Function Update Status with parameter id
    public static function updateStatus(UpdateProblemDto $updateProblemDto, int $id)
    {
        $user = Auth::user();
        if ($user->name !== 'Administrator') {
            throw new ApiResponseException(['You are not authorized'], ApiStatusEnum::UNAUTHORIZED);

        }
        // Validasi apakah status ada dalam enum
        $validStatuses = array_column(ProblemStatusEnum::cases(), 'value');

        if (!in_array($updateProblemDto->status, $validStatuses)) {
            throw new UnprocessableEntityHttpException('error entity');
        }

        // Ambil data incident
        $query = Problem::findOrFail($id); // agar

        // Update data lainnya
        $query->status = $updateProblemDto->status;
        $query->updated_at = now();

        $query->save();
    }
    public static function updateWorker(UpdateProblemDto $updateProblemDto, int $id)
    {
        $user = Auth::user();
        if ($user->name !== 'Worker') {
            throw new ApiResponseException(['You are not authorized'], ApiStatusEnum::UNAUTHORIZED);

        }
        // Validasi apakah status ada dalam enum


        // Ambil data incident
        $query = Problem::with(['personInControl'])->findOrFail($id); // agar

        if ($query->pic_id !== null && $query->pic_id !== $user->id) {
            throw new ApiResponseException(['You are not authorized to modify this incident.'], ApiStatusEnum::UNAUTHORIZED);
        }

        // Update data lainnya
        $query->comment = $updateProblemDto->comment;
        $query->pic_id = $user->id;
        $query->updated_at = now();

        $query->save();
    }

    // Function getAll
    public static function getAll(FilterDto $filterDto)
    {
        $query = Problem::with(['reporter', 'personInControl', 'categories']);

        if ($filterDto->search) {
            $query->where('subject', 'like', '%' . $filterDto->search . '%');
        }

        $Requests = $query->paginate($filterDto->length);

        $transformed = $Requests->getCollection()->map(function ($problem) {
            return [
                'id' => $problem->id,
                'subject' => $problem->subject,
                'status' => $problem->status,
                'comment' => $problem->comment,
                'created_at' => $problem->created_at,

                'reporter' => [
                    'id' => $problem->reporter?->id,
                    'name' => $problem->reporter?->name,
                ],
                'Person In Control' => [
                    'id' => $problem->personInControl?->id,
                    'name' => $problem->personInControl?->name,
                ],
                'categories' => $problem->categories->sortBy('id')->values()->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                    ];
                })->values(),
            ];
        });

        $Requests->setCollection($transformed);

        if ($Requests->total() === 0) {
            abort(404, 'Data not found');
        }

        return [
            'current_page' => $Requests->currentPage(),
            'total_data' => $Requests->total(),
            'total_page' => $Requests->lastPage(),
            'data' => $Requests->items(),
        ];
    }

    // Function get with Id
    public static function getId(int $id)
    {
        $query = Problem::with(['reporter', 'personInControl', 'categories'])->findOrFail($id);

        return [
            'data' => [
                'id' => $query->id,
                'subject' => $query->subject,
                'status' => $query->status,
                'comment' => $query->comment,
                'created_at' => $query->created_at,

                'reporter' => [
                    'id' => $query->reporter?->id,
                    'name' => $query->reporter?->name,
                ],
                'Person in Control' => [
                    'id' => $query->personInControl?->id ?? 'null',
                    'name' => $query->personInControl?->name ?? 'null',
                ],
                'categories' => $query->categories->sortBy('id')->values()->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                    ];
                })
            ],
        ];
    }

    // Function Get Category
    public static function getCategory()
    {
        $query = CategoryProblem::all();
        return ['data' => $query];
    }
    // Function softDelete
    public static function delete(int $id)
    {
        // validate
        $user = Auth::user();
        if ($user->name !== 'Administrator') {
            throw new ApiResponseException(['You are not authorized'], ApiStatusEnum::UNAUTHORIZED);
        }

        $query = Problem::findOrFail($id);
        $query->delete();
        $query->categories()->detach();
    }
}

