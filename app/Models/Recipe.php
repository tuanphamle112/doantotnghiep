<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Relations\RecipeRelation;

class Recipe extends Model
{
    use RecipeRelation;
    
    protected $fillable = [
        'name',
        'user_id',
        'recipe_number',
        'estimate_time',
        'description',
        'image',
        'video_link',
        'rating_point',
        'level_id',
        'people_number',
        'status',
    ];
}
