<?php

namespace App\Services;

use App\Models\RequestService;
use App\DTOs\RequestService\CreateRequestServiceDto;
use App\DTOs\RequestService\UpdateRequestServiceDto;
use App\DTOs\FilterDto;
use App\DTOs\ApiResponseDto;
use App\Enums\ApiStatusEnum;
use App\Enums\RequestServiceStatusEnum;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
class RequestServices
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
    public static function create(CreateRequestServiceDto $createRequestServiceDto): void
    {
        // validate
        if (!$createRequestServiceDto->requester_id || !$createRequestServiceDto->category_id) {
            throw new UnprocessableEntityHttpException('Error!!! Either reporter or category must be specified');
        }

        // Buat incident
        $RequestService = RequestService::create([
            'subject' => $createRequestServiceDto->subject,
            'description' => $createRequestServiceDto->description,
            'requester_id' => $createRequestServiceDto->requester_id,
            'status' => RequestServiceStatusEnum::SUBMITTED,
        ]);

        // Hubungkan ke kategori (dari relasi many-to-many)
        $RequestService->categories()->attach($createRequestServiceDto->category_id, [
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    // Function Update with parameter id
    public static function update(UpdateRequestServiceDto $updateRequestServiceDto, int $id)
    {

        // Validasi apakah status ada dalam enum
        $validStatuses = array_column(RequestServiceStatusEnum::cases(), 'value');

        if (!in_array($updateRequestServiceDto->status, $validStatuses)) {
            throw new UnprocessableEntityHttpException('error entity');
        }

        // Ambil data incident
        $RequestService = RequestService::findOrFail($id); // agar
        // Jika resolver_id belum ada, baru kita isi
        if (!$RequestService->pic_id && $updateRequestServiceDto->pic_id) {
            $RequestService->pic_id = $updateRequestServiceDto->pic_id;
        }

        // Update data lainnya
        $RequestService->status = $updateRequestServiceDto->status;
        $RequestService->comment = $updateRequestServiceDto->comment;
        $RequestService->updated_at = now();

        $RequestService->save();
    }

    // Function getAll
    public static function getAll(FilterDto $filterDto)
    {
        $query = RequestService::with(['requester', 'personInControl', 'categories']);

        if ($filterDto->search) {
            $query->where('subject', 'like', '%' . $filterDto->search . '%');
        }

        $Requests = $query->paginate($filterDto->length);

        $transformed = $Requests->getCollection()->map(function ($req) {
            return [
                'id' => $req->id,
                'subject' => $req->subject,
                'status' => $req->status,
                'comment' => $req->comment,
                'created_at' => $req->created_at,

                'requester' => [
                    'id' => $req->requester?->id,
                    'name' => $req->requester?->name,
                ],
                'pic' => [
                    'id' => $req->pic?->id,
                    'name' => $req->pic?->name,
                ],
                'categories' => $req->categories->sortBy('id')->values()->map(function ($category) {
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
        $query = RequestService::with(['requester', 'personInControl', 'categories'])->findOrFail($id);

        return [
            'data' => [
                'id' => $query->id,
                'subject' => $query->subject,
                'status' => $query->status,
                'comment' => $query->comment,
                'created_at' => $query->created_at,

                'requester' => [
                    'id' => $query->requester?->id,
                    'name' => $query->requester?->name,
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

    // Function softDelete
    public static function delete(int $id)
    {
        $query = RequestService::findOrFail($id);
        $query->delete();
        $query->categories()->detach();
    }
}

