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

    public function insertIngredient($data = [])
    {
        return $this->model->ingredient()->create($data);
    }

    public function insertCookingStep($data = [])
    {
        return $this->model->cookingStep()->createMany($data);
    }

    public function updateStepImage($id, $i)
    {
        return $this->findOrFail($id)
        ->cookingStep()
        ->where('step_number', $i)
        ->update(['image' => null]);
    }

    public function updateStepImageWithData($id, $i, $dataString = '')
    {
        return $this->findOrFail($id)
        ->cookingStep()
        ->where('step_number', $i)
        ->update(['image' => $dataString]);
    }

    public function updateIngredient($id, $data = [])
    {
        return $this->findOrFail($id)->ingredient()->update($data);
    }

    public function deleteCookingStep($id)
    {
        return $this->findOrFail($id)->cookingStep()->delete();
    }

    public function createCookingStep($id, $data = [])
    {
        return $this->findOrFail($id)->cookingStep()->createMany($data);
    }

    public function findCookingStep($id, $stepId)
    {
        return $this->findOrFail($id)
        ->cookingStep()
        ->where('step_number', $stepId)
        ->firstOrFail();
    }

    public function updateCookingStep($id, $stepId, $data = [])
    {
        return $this->findOrFail($id)
        ->cookingStep()
        ->where('step_number', $stepId)
        ->update($data);
    }

    public function getAllActiveRecipe($with = [], $select = ['*'])
    {
        $recipes = $this->model
        ->with($with)
        ->where('status', config('manual.recipe_status.Actived'))
        ->take(config('manual.home_page.take.feature_recipe'))
        ->orderBy('id', 'DESC')
        ->get();

        return $recipes;
    }

    public function getOneFeatureRecipe($with = [], $select = ['*'])
    {
        $recipe = $this->model
        ->with($with)
        ->where('status', config('manual.recipe_status.Actived'))
        ->orderBy('id', 'DESC')
        ->firstOrFail();

        return $recipe;
    }

    public function getAllRecipeOfOneUser($paginate, $userId, $with = [], $select = ['*'])
    {
        $recipes = $this->model
        ->with($with)
        ->where('user_id', $userId)
        ->orderBy('id', 'DESC')
        ->paginate($paginate);

        return $recipes;
    }

    public function getRecipeStepInfo($id, $stepNumber)
    {
        $recipe = $this->model->findOrFail($id);
        $step = $recipe->cookingStep()
        ->where('step_number', $stepNumber)
        ->first();

        return $step;
    }

    public function getOldImage($id, $stepNumber)
    {
        $recipe = $this->model->findOrFail($id);
        $step = $recipe->cookingStep()
        ->where('step_number', $stepNumber)
        ->firstOrFail();

        return $step->image;
    }

    public function getLastStepId($id)
    {
        $recipe = $this->model->findOrFail($id);
        $stepId = $recipe->cookingStep()
        ->orderBy('step_number', 'DESC')
        ->firstOrFail();

        return $stepId->step_number;
    }

    public function getRecipeByCategory($paginate, $categoryId)
    {
        $recipe = $this->model->with(['level', 'categories'])
        ->where('category_id', $categoryId)
        ->paginate($paginate);
    }
}
