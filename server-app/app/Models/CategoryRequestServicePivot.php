<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryRequestServicePivot extends Model
{
    protected $table = 'category_request_service_pivots';

    protected $fillable = [
        'request_service_id',
        'category_request_id'
    ];
}
