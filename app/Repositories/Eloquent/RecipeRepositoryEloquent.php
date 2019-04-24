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

    public function updateStepImage($id, $i)
    {
        return $this->findOrFail($id)->cooking_step()->where('step_number', $i)->update(['image' => '']);
    }

    public function updateIngredient($id, $data = [])
    {
        return $this->findOrFail($id)->ingredient()->update($data);
    }

    public function deleteCookingStep($id)
    {
        return $this->findOrFail($id)->cooking_step()->delete();
    }

    public function createCookingStep($id, $data = [])
    {
        return $this->findOrFail($id)->cooking_step()->createMany($data);
    }
}
