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
    Route::get('change-language/{language}', 'HomeController@changeLanguage')->name('change-language');
});
