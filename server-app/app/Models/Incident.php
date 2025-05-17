<?php

namespace App\Models;
use App\Models\User;
use App\Models\CategoryIncident;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Incident extends Model
{

    protected $table = 'Incidents';

    use SoftDeletes;

    protected $fillable = [
        'subject',
        'description',
        'reporter_id',
        'category_id',
        'resolver_id',
        'status',
        'comment'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];


    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function resolver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolver_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(CategoryIncident::class, 'category_incident_pivots');
    }

}
