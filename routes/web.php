<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::group(['middleware' => 'locale'], function () {
    Auth::routes();
    Route::get('/', 'HomeController@index')->name('home');
    // admin route
    Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
        Route::resource('users', 'UserController');
        Route::resource('recipes', 'RecipeController');
        Route::resource('categories', 'CategoryController');
        Route::get('category/{id}/create', 'CategoryController@subCreate')->name('category.subCreate');
    });
    //user route
    Route::group(['middleware' => 'isLogin', 'namespace' => 'Frontend'], function () {
        Route::group(['prefix' => 'create-recipe'], function () {
            Route::get('recipe-info', 'CreateRecipeController@showName')->name('form.name');
            Route::post('submit-recipe-info', 'CreateRecipeController@createName')->name('recipe.name');
            
            Route::get('ingredient/{id}', 'CreateRecipeController@createIngredient')->name('form.ingredient');
            Route::post('ingredient/{id}', 'CreateRecipeController@submitIngredient')->name('recipe.ingredient');

            Route::get('step/{id}/step-{stepId}', 'CreateRecipeController@createCookingStep')->name('form.step');
            Route::post('step/{id}/step-{stepId}', 'CreateRecipeController@submitCookingStep')->name('recipe.step');
            
            Route::post('/upload-step-image', 'CreateRecipeController@uploadStepImage');

            Route::get('categories/{id}', 'CreateRecipeController@createCategories')->name('form.categories');
            Route::post('categories/{id}', 'CreateRecipeController@submitCategories')->name('recipe.categories');
        });
        Route::resource('my-recipe', 'MyRecipeController');
    });

    Route::get('/recipe/{recipeName}/{id}', 'Frontend\DetailRecipeController@index')->name('detail-recipe');
    Route::get('change-language/{language}', 'HomeController@changeLanguage')->name('change-language');
});
