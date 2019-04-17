<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Relations\RateRelation;

class Rate extends Model
{
    use RateRelation;
    
    protected $fillable = [
        'user_id',
        'recipe_id',
        'point_rate',
    ];
}
