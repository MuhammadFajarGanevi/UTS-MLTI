<?php

namespace App\Models;
use App\Models\Problem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class CategoryProblem extends Model
{
    protected $table = "category_problems";

    protected $fillable = [
        'name'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // relations
    public function problem(): BelongsToMany
    {
        return $this->belongsToMany(
            Problem::class,
            'category_problem_pivots',
            'category_problem_id',
            'problem_id'
        );
    }
}
