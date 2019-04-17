<?php

namespace App\Constracts\Eloquent;

use App\Constracts\Eloquent\BaseRepository;

interface RecipeRepository extends BaseRepository
{
    public function insertIngredient($data=[]);

    public function insertCookingStep($data=[]);
}
