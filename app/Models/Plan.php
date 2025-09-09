<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $primaryKey = 'plan_id';

    protected $fillable = [
        'user_id', // user foreign key
        'plan_name',
        'area_shape',
        'planting_system',
        'plant_spacing',
        'num_plants',
    ];
}
