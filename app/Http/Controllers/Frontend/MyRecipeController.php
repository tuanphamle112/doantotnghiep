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

class MyRecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    public function index()
    {
        $categories = $this->getCategoriesForNav();
        $levels = $this->level->all();
        $paginate = config('manual.pagination.recipe_home');
        $recipes = $this->recipe->getAllRecipeOfOneUser($paginate, Auth::user()->id, ['level']);

        return view('frontend.recipes.my-recipe.index', compact(
            'categories',
            'levels',
            'recipes'
        ));
    }

    public function updateCategories($id)
    {
        $categories = $this->getCategoriesForNav();
        $allCategories = $this->category->all();
        $recipe = $this->recipe->findOrFail($id);
        $recipeCategory = $recipe->categories;
        $lastStepId = $this->recipe->getLastStepId($id);
        
        return view('frontend.recipes.update-recipe.categories', compact(
            'id',
            'categories',
            'allCategories',
            'recipeCategory',
            'lastStepId'
        ));
    }

    public function submitUpdateCategories(Request $request, $id)
    {
        $recipe = $this->recipe->findOrFail($id);

        if ($request->categories == null) {
            return redirect()->back()->withErrors([__('Please take at least one category')]);
        }

        $recipe->categories()->sync($request->categories);

        $notification = [
            'message' => __('Update recipe successfully!'),
            'alert-type' => 'success',
        ];

        return redirect()->route('home')->with($notification);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = $this->getCategoriesForNav();
        $levels = $this->level->all();
        $recipe = $this->recipe->findOrfail($id);

        return view('frontend.recipes.update-recipe.first-form', compact(
            'categories',
            'levels',
            'recipe'
        ));
    }
    
    public function updateRecipeInfo(CreateRecipeFirstRequest $request, $id)
    {
        // upload file
        $mainImageName = $request->main_image_old;
        $imageStorageFolder = 'recipe' . $request->recipe_number;
        if (!is_null($request->main_image)) {
            $mainImageName = $imageStorageFolder . '/' . time() . $request->main_image->getClientOriginalName();
            Helper::putImageToUploadsFolder($mainImageName, $request->main_image);
            Helper::deleteOldImage($request->main_image_old);
        };

        $recipes = [
            'name' => $request->name,
            'user_id' => Auth::id(),
            'estimate_time' => $request->estimate_time,
            'description' => $request->description,
            'video_link' => $request->video,
            'level_id' => $request->level,
            'image' => $mainImageName,
            'people_number' => $request->people_number,
        ];
        
        $this->recipe->update($id, $recipes);
        
        return redirect()->route('form-update.ingredient', $id);
    }

    public function updateIngredient($id)
    {
        $categories = $this->getCategoriesForNav();
        $recipe = $this->recipe->findOrfail($id);
        $ingredientsString = $recipe->ingredient->name;
        $ingredients = explode(',', $recipe->ingredient->name);

        return view('frontend.recipes.update-recipe.ingredient-form', compact(
            'id',
            'categories',
            'ingredients',
            'ingredientsString'
        ));
    }

    public function submitIngredient(Request $request, $id)
    {
        $recipe = $this->recipe->findOrFail($id);

        $ingredients= [
            'name' => $request->ingredients,
        ];

        $recipe->ingredient()->update($ingredients);

        return redirect()->route('form-update.step', [
            'id' => $id,
            'stepId' => 1,
        ]);
    }

    public function updateCookingStep($id, $stepNumber)
    {
        $categories = $this->getCategoriesForNav();
        $recipe = $this->recipe->findOrFail($id);
        $stepInfo = $this->recipe->getRecipeStepInfo($id, $stepNumber);

        return view('frontend.recipes.update-recipe.cooking-step', compact(
            'id',
            'stepNumber',
            'categories',
            'recipe',
            'stepInfo'
        ));
    }

    public function submitUpdateCookingStep(CookingStepRequest $request, $id, $stepNumber)
    {
        $recipe = $this->recipe->findOrFail($id);
        $thisStep = $this->recipe->findCookingStep($id, $stepNumber);
        switch ($request->submit_step) {
            case 'next_step':
                $nextStep = $stepNumber + 1;
                $dataStepInfo = [
                    'step_number' => $request->step_number,
                    'name' => $request->name,
                    'time' => $request->time,
                    'note' => $request->note,
                    'content' => $request->content,
                ];
                if (isset($thisStep)) {
                    $this->recipe->updateCookingStep($id, $stepNumber, $dataStepInfo);
                } else {
                    $recipe->cookingStep()->create($dataStepInfo);
                }
                return redirect()->route('form-update.step', [
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
                    $this->recipe->updateCookingStep($id, $stepNumber, $dataStepInfo);
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

    public function deleteStepImage(Request $request)
    {
        $imageString = $request->imageString;
        $imageDeleteName = $request->imageName;
        $imageArray = explode(',', $imageString);
        
        if ((count($imageArray) > 1 && $key = array_search($imageDeleteName, $imageArray)) != false) {
            unset($imageArray[$key]);
            $imageSaveAble = implode(',', $imageArray);
        } else {
            $imageSaveAble = '';
        }

        Helper::deleteOldImage($imageDeleteName);
        $this->recipe->updateStepImageWithData($request->recipeId, $request->stepId, $imageSaveAble);

        return response()->json(['imageCutted' => $imageSaveAble]);
    }

    public function uploadStepImage(Request $request)
    {
        $stepNumber = $request->step_number;
        $recipeId = $request->id;
        $recipeNumber = $request->recipe_number;

        $imageStorageFolder = 'recipe' . $recipeNumber;
        $stepFileName = 'step_files' . $stepNumber;
        $oldImage = $this->recipe->getOldImage($recipeId, $stepNumber);
        $stepArrayImageName = '';
        $recipe = $this->recipe->findOrFail($recipeId);

        foreach ($request->step_file as $file) {
            $getFileOriginalName = time() . $file->getClientOriginalName();
            $stepImageName = $imageStorageFolder . '/' . $stepFileName . '/' . $getFileOriginalName;
            Helper::putImageToUploadsFolder($stepImageName, $file);
            
            $stepArrayImageName = $stepArrayImageName . ',' . $stepImageName;
        }

        $stepImage = rtrim($oldImage) . ',' . ltrim($stepArrayImageName, ',');
        $success = 'success';
        $this->recipe->updateStepImageWithData($recipeId, $stepNumber, $stepImage);

        return response()->json(['success' => json_decode($success)]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
