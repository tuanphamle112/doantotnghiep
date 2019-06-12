<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Constracts\Eloquent\CategoryRepository;
use App\Constracts\Eloquent\RecipeRepository;
use App\Constracts\Eloquent\LevelRepository;

use App\Helpers\Helper;
use Auth;
class SearchController extends Controller
{

    protected $category;
    protected $recipe;
    protected $level;
    public function __construct(
        CategoryRepository $category,
        RecipeRepository $recipe,
        LevelRepository $level
    ) {
        $this->category = $category;
        $this->recipe = $recipe;
        $this->level = $level;
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


    public function index()
    {
        $categories = $this->getCategoriesForNav();
        $paginate = config('manual.pagination.recipe_home');

        return view('frontend.recipes.search-recipe.index', compact(
            'categories'
        ));
    }

    public function searchByRecipe(Request $request)
    {
        $categories = $this->getCategoriesForNav();
        $recipes = Recipe::search($request->recipe_name)->paginate(2);

        return view('frontend.recipes.search-recipe.index', compact(
            'categories',
            'recipes'
        ));
    }

    public function searchByIngredient(Request $request)
    {
        $recipes = [];
        $categories = $this->getCategoriesForNav();
        $ingredients = Ingredient::search($request->ingredient_name)->get();
        
        foreach ($ingredients as $ingredient) {
            array_push($recipes, $ingredient->recipe);
        }
        return view('frontend.recipes.search-recipe.index', compact(
            'categories',
            'recipes'
        ));
    }
}
