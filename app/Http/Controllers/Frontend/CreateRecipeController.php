<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Constracts\Eloquent\CategoryRepository;
use App\Constracts\Eloquent\RecipeRepository;
use App\Constracts\Eloquent\UserRepository;
use App\Constracts\Eloquent\LevelRepository;
use App\Http\Requests\CreateRecipeFirstRequest;
use App\Http\Requests\CookingStepRequest;

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

    public function showName()
    {
        $categories = $this->getCategoriesForNav();
        $levels = $this->level->all();

        return view('frontend.recipes.create-recipe.form-1', compact(
            'categories',
            'levels'
        ));
    }

    public function createName(CreateRecipeFirstRequest $request)
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

        return redirect()->route('form.ingredient', ['id' => $recipe->id]);
    }

    public function createIngredient(Request $request, $id)
    {
        $categories = $this->getCategoriesForNav();

        return view('frontend.recipes.create-recipe.ingredient-form', compact(
            'id',
            'categories'
        ));
    }

    public function submitIngredient(Request $request, $id)
    {
        $recipe = $this->recipe->findOrFail($id);

        $ingredients= [
            'name' => $request->ingredients,
        ];

        $recipe->ingredient()->create($ingredients);
        
        return redirect()->route('form.step', [
            'id' => $recipe->id,
            'stepId' => 1,
        ]);
    }

    public function createCookingStep(Request $request, $id, $stepId)
    {
        $categories = $this->getCategoriesForNav();
        $recipe = $this->recipe->findOrFail($id);

        return view('frontend.recipes.create-recipe.cooking-step', compact(
            'id',
            'stepId',
            'categories',
            'recipe'
        ));
    }

    public function submitCookingStep(CookingStepRequest $request, $id, $stepId)
    {
        $recipe = $this->recipe->findOrFail($id);
        $thisStep = $this->recipe->findCookingStep($id, $stepId);
        switch ($request->submit_step) {
            case 'next_step':
                $nextStep = $stepId + 1;
                $dataStepInfo = [
                    'step_number' => $request->step_number,
                    'name' => $request->name,
                    'time' => $request->time,
                    'note' => $request->note,
                    'content' => $request->content,
                ];
                if (isset($thisStep)) {
                    $this->recipe->updateCookingStep($id, $stepId, $dataStepInfo);
                } else {
                    $recipe->cookingStep()->create($dataStepInfo);
                }

                return redirect()->route('form.step', [
                    $id,
                    $nextStep,
                ]);
                break;
        
            case 'next_form':
                $dataStepInfo = [
                    'step_number' => $request->step_number,
                    'name' => $request->name,
                    'time' => $request->time,
                    'note' => $request->note,
                    'content' => $request->content,
                ];
                if (isset($thisStep)) {
                    $this->recipe->updateCookingStep($id, $stepId, $dataStepInfo);
                } else {
                    $recipe->cookingStep()->create($dataStepInfo);
                }
                if (count($recipe->categories) > 0) {
                    return redirect()->route('form-update.categories', [
                        $id,
                    ]);
                } else {
                    return redirect()->route('form.categories', [
                        $id,
                    ]);
                }
                break;
        }
    }

    public function uploadStepImage(Request $request)
    {
        $imageStorageFolder = 'recipe' . $request->recipe_number;
        $stepFileName = 'step_files' . $request->step_number;
        $stepArrayImageName = '';
        $recipe = $this->recipe->findOrFail($request->id);
        foreach ($request->step_file as $file) {
            $getFileOriginalName = time() . $file->getClientOriginalName();
            $stepImageName = $imageStorageFolder . '/' . $stepFileName . '/' . $getFileOriginalName;
            Helper::putImageToUploadsFolder($stepImageName, $file);
            
            $stepArrayImageName = $stepArrayImageName . ',' . $stepImageName;
        }
        $stepImage = ltrim($stepArrayImageName, ',');

        $dataStep = [
            'step_number' => $request->step_number,
            'image' => $stepImage,
        ];
        $success = 'success';
        $recipe->cookingStep()->create($dataStep);

        return response()->json(['success' => json_decode($success)]);
    }

    public function createCategories($id)
    {
        $categories = $this->getCategoriesForNav();
        $allCategories = $this->category->all();
        $lastStepId = $this->recipe->getLastStepId($id);

        return view('frontend.recipes.create-recipe.categories', compact(
            'id',
            'categories',
            'allCategories',
            'lastStepId'
        ));
    }

    public function submitCategories(Request $request, $id)
    {
        $recipe = $this->recipe->findOrFail($id);

        if ($request->categories == null) {
            return redirect()->back()->withErrors([__('Please take at least one category')]);
        }

        $recipe->categories()->sync($request->categories);

        $notification = [
            'message' => __('Create recipe successfully! Your Recipe Are Being Check By Admin'),
            'alert-type' => 'success',
        ];

        return redirect()->route('home')->with($notification);
    }
}
