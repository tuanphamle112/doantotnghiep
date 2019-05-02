<?php

namespace App\Constracts\Eloquent;

use App\Constracts\Eloquent\BaseRepository;

interface RecipeRepository extends BaseRepository
{
    public function insertIngredient($data=[]);

    public function insertCookingStep($data=[]);

    public function updateStepImage($id, $i);

    public function updateIngredient($id, $data = []);

    public function deleteCookingStep($id);

    public function createCookingStep($id, $data = []);

    public function getAllActiveRecipe($with = [], $select = ['*']);

    public function getOneFeatureRecipe($with = [], $select = ['*']);
}
