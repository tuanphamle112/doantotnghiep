<?php

namespace App\Models\Relations;

use App\User;
use App\Models\Recipe;

trait RateRelation
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }
}
