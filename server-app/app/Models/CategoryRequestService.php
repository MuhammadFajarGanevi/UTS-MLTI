<?php

namespace App\Models;

use App\Models\RequestService;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class CategoryRequestService extends Model
{
    protected $table = 'category_request_services';

    protected $fillable = [
        'name',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    public function requestService(): BelongsToMany
    {
        return $this->belongsToMany(
            RequestService::class,
            'category_request_service_pivots',
            'category_service_id',
            'request_service_id'
        );
    }
}
