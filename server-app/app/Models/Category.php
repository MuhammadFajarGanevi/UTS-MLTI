<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Incident;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    public function categoryIncident(): HasMany
    {
        return $this->hasMany(Incident::class, 'incidents_category_id');
    }

}
