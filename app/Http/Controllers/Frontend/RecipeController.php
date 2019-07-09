<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use App\Constracts\Eloquent\CategoryRepository;
use App\Constracts\Eloquent\UserRepository;
use App\Constracts\Eloquent\RecipeRepository;
use App\Constracts\Eloquent\LevelRepository;
use App\Models\Recipe;
use App\Models\Follow;

use App\Helpers\Helper;
use Auth;

class RecipeController extends Controller
{
    protected $category;
    protected $recipe;
    protected $level;
    protected $user;

    public function __construct(
        CategoryRepository $category,
        RecipeRepository $recipe,
        LevelRepository $level,
        UserRepository $user
    ) {
        $this->category = $category;
        $this->recipe = $recipe;
        $this->level = $level;
        $this->user = $user;
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
        $levels = $this->level->all();
        $paginate = config('manual.pagination.recipe_home');
        $recipes = $this->recipe->paginate($paginate, ['level']);

        return view('frontend.recipes.index', compact(
            'categories',
            'levels',
            'recipes'
        ));
    }

    public function showParentCategories($parentLink)
    {
        $categories = $this->getCategoriesForNav();
        $levels = $this->level->all();
        $paginate = config('manual.pagination.recipe_home');

        $parentCategory = $this->category->getParentCategoryByLink($parentLink)->firstOrFail();

        $subCategories = $this->category->getSubCategoryByParentId($parentCategory->id)->get();
        $categoryIDs = [$parentCategory->id];

        foreach ($subCategories as $subCategory) {
            $categoryIDs[] = $subCategory->id;
        }
        $listRecipe = new Collection;
        $recipeByCategory = $this->category->getAllRecipeIdByCategory($categoryIDs);
        foreach ($recipeByCategory as $category) {
            $listRecipe=$listRecipe->merge($category->recipe);
        }
        $allRecipe = Helper::paginate($listRecipe);

        return view('frontend.recipes.recipe-by-category', compact(
            'categories',
            'levels',
            'recipes',
            'parentCategory',
            'allRecipe'
        ));
    }

    public function showSubCategory($parentLink, $subLink)
    {
        $categories = $this->getCategoriesForNav();
        $levels = $this->level->all();
        $paginate = config('manual.pagination.recipe_home');

        $parentCategory = $this->category->getParentCategoryByLink($parentLink)->firstOrFail();
        $subCategory = $this->category->getSubCategoryByLink($subLink, $parentCategory->id)->firstOrFail();

        $recipeBySubCategory = $this->category
        ->getRecipeBySubCategory($parentCategory->id, $subCategory->id);
        
        $allRecipe = Helper::paginate($recipeBySubCategory->recipe);

        return view('frontend.recipes.recipe-by-subcategory', compact(
            'categories',
            'levels',
            'recipes',
            'parentCategory',
            'subCategory',
            'allRecipe'
        ));
    }

    public function getAllRecipesOfUser($id) 
    {
        $categories = $this->getCategoriesForNav();
        $user = $this->user->findOrFail($id);

        $notificationsNum = count($user->unreadNotifications);
        $followStatus = Follow::where('user_id', $id)->where('user_id_follow', Auth::user()->id)->first();
        $following = Follow::where('user_id_follow', $id)->with('getUserBeFollow')->paginate(8);
        $follower = Follow::where('user_id', $id)->with('getUserFollowing')->paginate(8);

        $recipeOfUser = Recipe::where('user_id', $id)->where('status', config('manual.recipe_status.Actived'))->paginate(8);

        return view('frontend.recipes.recipe-of-user', compact(
            'categories',
            'user',
            'followStatus',
            'following',
            'notificationsNum',
            'follower',
            'recipeOfUser'
        ));
    }
}
