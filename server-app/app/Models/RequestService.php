<?php

namespace App\Models;

use App\Models\User;
use App\Models\CategoryRequestService;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RequestService extends Model
{
    protected $table = 'request_services';

    protected $fillable = [
        'subject',
        'description',
        'status',
        'requester_id',
        'pic_id',
        'comment'
    ];

    protected $casts = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    use SoftDeletes;

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }
    public function personInControl(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pic_id');
    }
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            CategoryRequestService::class,
            'category_request_service_pivots',
            'request_service_id',
            'category_request_id'
        );
    }
}
