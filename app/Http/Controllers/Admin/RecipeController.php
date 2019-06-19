<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Constracts\Eloquent\RecipeRepository;
use App\Constracts\Eloquent\LevelRepository;
use App\Constracts\Eloquent\CategoryRepository;
use App\Helpers\Helper;

use Auth;
use Storage;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $recipe;
    protected $level;
    protected $category;

    public function __construct(
        RecipeRepository $recipe,
        LevelRepository $level,
        CategoryRepository $category
    ) {
        $this->recipe = $recipe;
        $this->level = $level;
        $this->category = $category;
    }

    public function index()
    {
        $recipes = $this->recipe->getAllRecipeDesc(config('manual.pagination.recipe'), ['level']);
        
        return view('admin.recipes.index', compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $levels = $this->level->all();
        $categories = $this->category->all();

        return view('admin.recipes.create', compact(
            'levels',
            'categories'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // upload file
        $mainImageName = '';
        $imageStorageFolder = 'recipe' . $request->recipe_number;
        if (!is_null($request->main_image)) {
            $mainImageName = $imageStorageFolder . '/' . time() . $request->main_image->getClientOriginalName();

            Helper::putImageToUploadsFolder($mainImageName, $request->main_image);
        };
        $stepInsert = [];

        for ($i = 1; $i <= $request->step_num; $i++) {
            $stepFileName = 'step_files' . $i;
            $stepName = 'step' . $i;
            $stepArrayImageName = '';
            $stepArray = $request->$stepName; // include content, time, note, name of each step
            $fileCount = 0;
            if (!empty($request->$stepFileName)) {
                foreach ($request->$stepFileName as $file) {
                    $fileCount++;
    
                    if ($fileCount <= 6) {
                        $getFileOriginalName = time() . $file->getClientOriginalName();
                        $stepImageName = $imageStorageFolder . '/' . $stepFileName . '/' . $getFileOriginalName;
                        Helper::putImageToUploadsFolder($stepImageName, $file);
                        
                        $stepArrayImageName = $stepArrayImageName . ',' . $stepImageName;
                    } else {
                        break;
                    }
                }
                $stepArray['image'] = ltrim($stepArrayImageName, ',');
            }
            $stepArray['step_number'] = $i;
            array_push($stepInsert, $stepArray);
        }

        // end upload file

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

        $ingredient = [
            'name' => $request->ingredients,
        ];

        $recipe = $this->recipe->create($recipes);
        $recipe->ingredient()->create($ingredient);
        $recipe->categories()->sync($request->categories);
        $recipe->cookingStep()->createMany($stepInsert);

        $notification = [
            'message' => __('Create recipe successfully!'),
            'alert-type' => 'success',
        ];

        return redirect()->route('recipes.index')->with($notification);
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
        $recipe = $this->recipe->findOrFail($id);
        $levels = $this->level->all();
        $categories = $this->category->all();
        $ingredientsSet =  $recipe->ingredient->name;
        $cookingSteps = $recipe->cookingStep;
        $levelRecipe = $recipe->level;
        $ingredients = explode(',', $recipe->ingredient->name);
        $numberOfStep = count($cookingSteps);
        $categoriesSelected = $recipe->categories;

        return view('admin.recipes.update', compact(
            'recipe',
            'cookingSteps',
            'levels',
            'levelRecipe',
            'ingredients',
            'ingredientsSet',
            'numberOfStep',
            'categories',
            'categoriesSelected'
        ));
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
        $imageStorageFolder = 'recipe' . $request->recipe_number;
        $mainImageName = $request->main_image_old;
            
        $recipeUpdateData = [];
        if (!is_null($request->main_image)) {
            $mainImageName = $imageStorageFolder . '/' . time() . $request->main_image->getClientOriginalName();
            Helper::putImageToUploadsFolder($mainImageName, $request->main_image);
            Helper::deleteOldImage($request->main_image_old);
        };
        $stepInsert = [];

        for ($i = 1; $i <= $request->step_num; $i++) {
            $stepFileName = 'step_files' . $i;
            $allStepFileName = 'step_files_hidden' . $i;
            $stepName = 'step' . $i;
            $imageNum = 'image_num' . $i;
            $stepArray = $request->$stepName; // include content, time, note, name of each step
            
            if (!is_null($request->$imageNum)) {
                $fileCount = $request->$imageNum;
            } else {
                $fileCount = 0;
            }
            $stepArrayImageName = $request->$allStepFileName;
            if (!empty($request->$stepFileName)) {
                foreach ($request->$stepFileName as $file) {
                    $fileCount++;
    
                    if ($fileCount <= 6 && !is_null($file)) {
                        $getFileOriginalName = time() . $file->getClientOriginalName();
                        $stepImageName = $imageStorageFolder . '/' . $stepFileName . '/' . $getFileOriginalName;
                        Helper::putImageToUploadsFolder($stepImageName, $file);
                        $stepArrayImageName = $stepArrayImageName . ',' . $stepImageName;
                    } else {
                        break;
                    }
                }
            }
            $stepArray['image'] = ltrim($stepArrayImageName, ',');
            var_dump($stepArray);
           
            if (isset($stepArray['clear']) && $stepArray['clear'] == 'cleared') {
                Helper::deleteDirectory($imageStorageFolder . '/' . $stepFileName);
                $this->recipe->updateStepImage($id, $i);
            }
            $stepArray['step_number'] = $i;

            array_push($stepInsert, $stepArray);
        }
        $recipes = [
            'name' => $request->name,
            'recipe_number' => $request->recipe_number,
            'estimate_time' => $request->estimate_time,
            'description' => $request->description,
            'video_link' => $request->video,
            'level_id' => $request->level,
            'image' => $mainImageName,
            'status' => $request->status,
            'people_number' => $request->people_number,
        ];

        $ingredient = [
            'name' => $request->ingredients,
        ];

        $recipe = $this->recipe->findOrFail($id);
        $this->recipe->update($id, $recipes);
        $this->recipe->updateIngredient($id, $ingredient);
        $recipe->categories()->sync($request->categories);
        $this->recipe->deleteCookingStep($id);
        $this->recipe->createCookingStep($id, $stepInsert);
        
        $notification = [
            'message' => __('Update recipe successfully!'),
            'alert-type' => 'success',
        ];
        
        return redirect()->route('recipes.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $recipe = $this->recipe->findOrFail($id);
        Helper::deleteDirectory('recipe' . $recipe->recipe_number);
        $recipe->categories()->detach();
        
        $this->recipe->destroy($id);

        $notification = [
            'message' => __('Delete recipe successfully!'),
            'alert-type' => 'warning',
        ];

        return redirect()->route('recipes.index')->with($notification);
    }
}
