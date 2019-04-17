<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Relations\IngredientRelation;

class Ingredient extends Model
{
    use IngredientRelation;
    
    protected $fillable = [
        'name',
        'note',
        'recipe_id',
    ];
}
