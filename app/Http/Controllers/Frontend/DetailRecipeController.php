<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Constracts\Eloquent\CategoryRepository;
use App\Constracts\Eloquent\RecipeRepository;
use App\Constracts\Eloquent\WishlistRepository;
use App\Helpers\Helper;
use Auth;

class DetailRecipeController extends Controller
{
    protected $category;
    protected $recipe;
    protected $wishlist;

    public function __construct(
        CategoryRepository $category,
        RecipeRepository $recipe,
        WishlistRepository $wishlist
    ) {
        $this->category = $category;
        $this->recipe = $recipe;
        $this->wishlist = $wishlist;
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
        $wishlist = null;

        $recipe = $this->recipe->findOrFail($id);
        $cookingSteps = $recipe->cookingStep;
        $createdAtRecipe = $recipe->user->created_at->format('Y-m-d');
        $ingredientArray = explodeComma($recipe->ingredient->name);
        $comments = $recipe->comments;
        $categories = $this->getCategoriesForNav();

        if (Auth::check()) {
            $wishlist = $this->wishlist->showWistList(Auth::user()->id, $recipe->id);
        }
        return view('frontend.recipes.detail-recipe', compact(
            'categories',
            'recipe',
            'createdAtRecipe',
            'ingredientArray',
            'cookingSteps',
            'comments',
            'wishlist'
        ));
    }
}
