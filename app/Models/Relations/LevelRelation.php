<?php

namespace App\Models\Relations;

use App\Models\Recipe;

trait LevelRelation
{
    public function recipe()
    {
        return $this->hasMany(Recipe::class, 'level_id');
    }
}
