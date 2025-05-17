<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryProblemPivot extends Model
{
    protected $table = 'category_problem_pivots';

    protected $fillable = [
        'problem_id',
        'category_problem_id'
    ];
}
