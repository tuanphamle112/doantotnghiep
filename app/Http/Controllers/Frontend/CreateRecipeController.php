<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Constracts\Eloquent\CategoryRepository;
use App\Constracts\Eloquent\RecipeRepository;
use App\Constracts\Eloquent\UserRepository;
use App\Constracts\Eloquent\LevelRepository;
use App\Http\Requests\CreateRecipeFirstRequest;

use App\Helpers\Helper;
use Auth;

class CreateRecipeController extends Controller
{
    protected $category;
    protected $recipe;
    protected $user;
    protected $level;

    public function __construct(
        CategoryRepository $category,
        RecipeRepository $recipe,
        LevelRepository $level,
        UserRepository $user
    ) {
        $this->category = $category;
        $this->recipe = $recipe;
        $this->user = $user;
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

    public function showFirstForm()
    {
        $categories = $this->getCategoriesForNav();
        $levels = $this->level->all();

        return view('frontend.create-recipe.form-1', compact(
            'categories',
            'levels'
        ));
    }

    public function createFirstForm(CreateRecipeFirstRequest $request)
    {
        // upload file
        $mainImageName = '';
        $imageStorageFolder = 'recipe' . $request->recipe_number;
        if (!is_null($request->main_image)) {
            $mainImageName = $imageStorageFolder . '/' . time() . $request->main_image->getClientOriginalName();

            Helper::putImageToUploadsFolder($mainImageName, $request->main_image);
        };

        $recipes = [
            'name' => $request->name,
            'recipe_number' => $request->recipe_number,
            'user_id' => Auth::id(),
            'estimate_time' => $request->estimate_time,
            'description' => $request->description,
            'video_link' => $request->video,
            'level_id' => $request->level,
            'image' => $mainImageName,
            'people_number' => $request->people_number,
        ];

        $recipe = $this->recipe->create($recipes);

        return redirect()->route('recipe.second', ['id' => $recipe->id]);
    }

    public function createSecondForm(Request $request, $id)
    {
    }
}
