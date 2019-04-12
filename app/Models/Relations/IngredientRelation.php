<?php

namespace App\Models\Relations;

use App\Models\Recipe;

trait IngredientRelation
{
    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }
}
