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
    Route::get('/change-language/{language}', 'HomeController@changeLanguage')->name('change-language');

    Route::get('search/index', 'SearchController@index')->name('search.index');
    Route::post('search/ingredient', 'SearchController@searchByIngredient')->name('search.ingredient');
    Route::post('search/recipe', 'SearchController@searchByRecipe')->name('search.recipe');
    // admin route
    Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
        Route::resource('users', 'UserController');
        Route::resource('recipes', 'RecipeController');
        Route::resource('manage-post', 'PostAdminController');
        Route::put('update-status/recipe/{id}', 'RecipeController@updateStatus')->name('recipes.update-status');
        Route::put('update-status/post/{id}', 'PostAdminController@updateStatus')->name('posts.update-status');
        Route::resource('categories', 'CategoryController');
        Route::get('category/{id}/create', 'CategoryController@subCreate')->name('category.subCreate');
        Route::resource('gifts', 'GiftController');
        Route::get('comments', 'CommentController@recipeComment')->name('admin.comment.index');
        Route::get('comments/posts', 'CommentController@postComment')->name('admin.comment.post');
        Route::delete('/delete-comment/{id}', 'CommentController@deleteComment')->name('admin.comment.delete');
    });
    //user route
    Route::group(['namespace' => 'Frontend'], function () {
        Route::group(['middleware' => 'isLogin'], function () {
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
            Route::group(['prefix' => 'update-recipe'], function () {
                Route::post('submit-recipe-info/{id}', 'MyRecipeController@updateRecipeInfo')->name('update-recipe.info');
    
                Route::get('ingredient/{id}', 'MyRecipeController@updateIngredient')->name('form-update.ingredient');
                Route::post('ingredient/{id}', 'MyRecipeController@submitIngredient')->name('update-recipe.ingredient');
    
                Route::get('step/{id}/step-{stepId}', 'MyRecipeController@updateCookingStep')->name('form-update.step');
                Route::post('step/{id}/step-{stepId}', 'MyRecipeController@submitUpdateCookingStep')->name('update-recipe.step');
    
                Route::post('/upload-step-image', 'MyRecipeController@uploadStepImage');
    
                Route::post('/delete-step-image', 'MyRecipeController@deleteStepImage');
    
                Route::get('categories/{id}', 'MyRecipeController@updateCategories')->name('form-update.categories');
                Route::post('categories/{id}', 'MyRecipeController@submitUpdateCategories')->name('update-recipe.categories');
            });
            // my posts
            Route::get('gift-confirm/{id}', 'GiftController@confirm')->name('gift.confirm');

            Route::get('my-post', 'PostController@myPostIndex')->name('my-posts.index');
            Route::get('my-post/{id}', 'PostController@myPostEdit')->name('my-posts.edit');
            Route::put('my-post/{id}', 'PostController@myPostUpdate')->name('my-posts.update');
            Route::delete('my-post/{id}', 'PostController@myPostDelete')->name('my-posts.destroy');
            // end my posts
            Route::get('/profile/{id}', 'ProfileController@index')->name('profile.index');
            Route::put('/profile/avatar/update/{id}', 'ProfileController@updateMyAvatar')->name('profile.avatar');

            Route::put('/profile/info-update/{id}', 'ProfileController@updateMyInfo')->name('profile.info');
            Route::get('/change-password', 'ProfileController@showChangePasswordForm')->name('changePassword.form');
            Route::post('/change-password', 'ProfileController@changePassword')->name('changePassword');

            Route::post('/comment/{id}', 'CommentController@storeComment')->name('comment.store');

            Route::delete('/delete-comment/{id}', 'CommentController@deleteComment')->name('comment.delete');
            Route::patch('/edit-comment/{id}', 'CommentController@editComment')->name('comment.edit');

            Route::resource('wishlist', 'WishlistController');
        });
        Route::resource('posts', 'PostController');
        Route::get('gift-list', 'GiftController@index')->name('gift.list');
        Route::get('/recipes', 'RecipeController@index')->name('list-recipe.index');
        Route::get('/{parent}', 'RecipeController@showParentCategories')->name('nav');
        Route::get('/{parentLink}/{subLink}', 'RecipeController@showSubCategory')->name('sub_Nav');
    
        Route::get('/recipe/{recipeName}/{id}', 'DetailRecipeController@index')->name('detail-recipe');
    });
});
