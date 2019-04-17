<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Relations\CookingStepRelation;

class CookingStep extends Model
{
    use CookingStepRelation;

    protected $fillable = [
        'name',
        'step_number',
        'recipe_id',
        'content',
        'time',
        'note',
        'image',
    ];
}
