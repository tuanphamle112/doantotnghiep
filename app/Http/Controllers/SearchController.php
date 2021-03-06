<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\Post;
use App\User;
use App\Constracts\Eloquent\CategoryRepository;
use App\Constracts\Eloquent\RecipeRepository;
use App\Constracts\Eloquent\LevelRepository;
use App\Http\Requests\SearchByInfoRequest;
use App\Http\Requests\SearchByIngredientRequest;

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

    public function searchByRecipe(SearchByInfoRequest $request)
    {
        $recipes = [];
        $categories = $this->getCategoriesForNav();
        $allRecipes = Recipe::search($request->recipe_name)->get();
        $keyword = $request->recipe_name;

        foreach ($allRecipes as $recipe) {
            if ($recipe->status != config('manual.recipe_status.Actived')) {
                continue;
            }
            array_push($recipes, $recipe);
        }

        return view('frontend.recipes.search-recipe.index', compact(
            'categories',
            'recipes',
            'keyword'
        ));
    }

    public function searchByIngredient(SearchByIngredientRequest $request)
    {
        $recipes = [];
        $categories = $this->getCategoriesForNav();
        $ingredients = Ingredient::search($request->ingredient_name)->get();
        $keyword = $request->ingredient_name;

        foreach ($ingredients as $ingredient) {
            if ($ingredient->recipe->status != config('manual.recipe_status.Actived')) {
                continue;
            }
            array_push($recipes, $ingredient->recipe);
        }
        
        return view('frontend.recipes.search-recipe.index', compact(
            'categories',
            'recipes',
            'keyword'
        ));
    }

    public function searchAll(Request $request)
    {
        $validatedData = $request->validate([
            'search_input' => 'required|max:100',
        ]);
        $categories = $this->getCategoriesForNav();
        
        $recipes = [];
        $posts = [];
        $allRecipes = Recipe::search($request->search_input)->get();
        $allPosts = Post::search($request->search_input)->get();
        $users = User::search($request->search_input)->get();
        foreach ($allRecipes as $recipe) {
            if ($recipe->status != config('manual.recipe_status.Actived')) {
                continue;
            }
            array_push($recipes, $recipe);
        }
        foreach ($allPosts as $post) {
            if ($post->status != config('manual.post_status.Actived')) {
                continue;
            }
            array_push($posts, $post);
        }

        $keyword = $request->search_input;
        $resultNum = count($users) + count($posts) + count($recipes);

        return view('frontend.all-search', compact(
            'categories',
            'recipes',
            'keyword',
            'posts',
            'users',
            'resultNum'
        ));
    }
}
