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
    Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
        Route::resource('users', 'Admin\UserController');
        Route::resource('recipes', 'Admin\RecipeController');
        Route::resource('categories', 'Admin\CategoryController');
        Route::get('category/{id}/create', 'Admin\CategoryController@subCreate')->name('category.subCreate');
    });
    //user route
    Route::group(['middleware' => 'isLogin'], function () {
        Route::group(['prefix' => 'create-recipe'], function () {
            Route::get('recipe-info', 'Frontend\CreateRecipeController@showFirstForm')->name('name-form');
            Route::post('submit-recipe-info', 'Frontend\CreateRecipeController@createFirstForm')->name('recipe.first');
            Route::get('ingredient/{id}', 'Frontend\CreateRecipeController@createSecondForm')->name('recipe.second');
        });
    });

    Route::get('/recipe/{recipeName}/{id}', 'Frontend\DetailRecipeController@index')->name('detail-recipe');
    Route::get('change-language/{language}', 'HomeController@changeLanguage')->name('change-language');
});
