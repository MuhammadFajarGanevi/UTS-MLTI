<?php

namespace App\Models;

use App\Models\User;
use App\Models\CategoryProblemPivot;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Problem extends Model
{
    protected $table = 'problems';

    use SoftDeletes;

    protected $fillable = [
        'subject',
        'description',
        'reporter_id',
        'pic_id',
        'status',
        'comment'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];


    // relations
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'reporter_id'
        );
    }
    public function personInControl(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'pic_id'
        );
    }
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            CategoryProblem::class,
            'category_problem_pivots',
            'problem_id',
            'category_problem_id'
        );
    }

}
