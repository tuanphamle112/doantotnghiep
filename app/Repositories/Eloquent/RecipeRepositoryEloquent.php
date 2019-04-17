<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepositoryEloquent;
use App\Constracts\Eloquent\RecipeRepository;

use App\Models\Recipe;

class RecipeRepositoryEloquent extends BaseRepositoryEloquent implements RecipeRepository
{
    public $model;

    public function __construct(Recipe $recipe)
    {
        $this->model = $recipe;
    }

    public function insertIngredient($data=[])
    {
        return $this->model->ingredient()->create($data);
    }

    public function insertCookingStep($data=[])
    {
        return $this->model->cooking_step()->createMany($data);
    }
}
