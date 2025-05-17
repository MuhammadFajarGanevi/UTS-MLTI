<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryIncidentPivot extends Model
{
    protected $table = 'category_incident_pivots';
    protected $fillable = ['incident_id', 'category_incident_id'];

}
