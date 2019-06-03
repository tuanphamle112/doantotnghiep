<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Constracts\Eloquent\CategoryRepository;
use App\Constracts\Eloquent\RecipeRepository;
use App\Helpers\Helper;

class DetailRecipeController extends Controller
{
    protected $category;
    protected $recipe;

    public function __construct(
        CategoryRepository $category,
        RecipeRepository $recipe
    ) {
        $this->category = $category;
        $this->recipe = $recipe;
    }
    public function getCategoriesForNav()
    {
        $categories = [];
        $categoryParents = $this->category->getAllParentCategories();

        foreach ($categoryParents as $categoryParent) {
            $parentId = $categoryParent->id;
            $categoryChildren = $this->category->getChildrenCategories($parentId);

            $categoryParent->children = $categoryChildren;
            $categories[] = $categoryParent;
        }

        return $categories;
    }

    public function index($name, $id)
    {
        $recipe = $this->recipe->findOrFail($id);
        $cookingSteps = $recipe->cookingStep;
        $createdAtRecipe = $recipe->user->created_at->format('Y-m-d');
        $ingredientArray = explodeComma($recipe->ingredient->name);
        $comments = $recipe->comments;
        $categories = $this->getCategoriesForNav();
        
        return view('frontend.recipes.detail-recipe', compact(
            'categories',
            'recipe',
            'createdAtRecipe',
            'ingredientArray',
            'cookingSteps',
            'comments'
        ));
    }
}
