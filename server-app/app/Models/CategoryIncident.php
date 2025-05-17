<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Incident;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CategoryIncident extends Model
{
    protected $table = 'category_incidents';

    protected $fillable = [
        'name',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    public function incidents(): BelongsToMany
    {
        return $this->belongsToMany(Incident::class, 'category_incident_pivots');
    }

}
