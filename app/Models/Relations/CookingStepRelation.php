<?php

namespace App\Models\Relations;

use App\Models\Recipe;

trait CookingStepRelation
{
    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }
}
