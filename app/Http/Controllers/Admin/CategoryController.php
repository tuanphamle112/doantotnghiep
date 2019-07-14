<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Constracts\Eloquent\CategoryRepository;
use App\Http\Requests\CreateCategoryRequest;
use App\Constracts\Eloquent\RecipeRepository;
use App\Constracts\Eloquent\WishlistRepository;
use App\Constracts\Eloquent\UserRepository;
use App\Constracts\Eloquent\PostRepository;
use App\Helpers\Helper;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $recipe;
    protected $category;
    protected $wishlist;
    protected $user;
    protected $post;

    public function __construct(
        RecipeRepository $recipe,
        WishlistRepository $wishlist,
        CategoryRepository $category,
        UserRepository $user,
        PostRepository $post
    ) {
        $this->recipe = $recipe;
        $this->category = $category;
        $this->wishlist = $wishlist;
        $this->user = $user;
        $this->post = $post;
    }

    public function index()
    {
        $categories = [];
        $categoryParents = $this->category->getParentCategoriesPaginate(config('manual.pagination.category'));
        $wishlist = $this->wishlist->all();
        $users = $this->user->all();
        $posts = $this->post->all();
        $recipes = $this->recipe->getAllRecipeDesc(config('manual.pagination.recipe'), ['level']);

        foreach ($categoryParents as $categoryParent) {
            $parentId = $categoryParent->id;
            $categoryChildren = $this->category->getChildrenCategories($parentId);

            $categoryParent->children = $categoryChildren;
            $categories[] = $categoryParent;
        }
        $data['categories'] = $categories;
        $data['categoryParents'] = $categoryParents; //Paginate

        return view('admin.categories.index', compact(
            'data',
            'recipes',
            'wishlist',
            'users',
            'posts'
        ));
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
    public function store(CreateCategoryRequest $request)
    {
        $categoryImageName = null;
        $link = changeLink($request->link);
        if (!is_null($request->icon)) {
            $categoryImageName = time() . $request->icon->getClientOriginalName();
            $categoryIcon = 'categories/' . $categoryImageName;
            Helper::putImageToUploadsBaseFolder($categoryIcon, $request->icon);
        };
        $data = [
            'name' => $request->name,
            'link' => $link,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'icon' => $categoryImageName,
        ];

        $this->category->create($data);

        $notification = [
            'message' => __('Create category successfully!'),
            'alert-type' => 'success',
        ];
            
        return redirect()->route('categories.index')->with($notification);
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
        $category = $this->category->findOrFail($id);
        $wishlist = $this->wishlist->all();
        $users = $this->user->all();
        $posts = $this->post->all();
        $recipes = $this->recipe->getAllRecipeDesc(config('manual.pagination.recipe'), ['level']);
        $optionParentCategory = $this->category->getOptionParentCategories();

        return view('admin.categories.update', compact(
            'category',
            'optionParentCategory',
            'recipes',
            'wishlist',
            'users',
            'posts'
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
        $categoryImageName = $request->old_icon;
        $link = changeLink($request->link);
        if (!is_null($request->icon)) {
            $categoryImageName = time() . $request->icon->getClientOriginalName();
            $categoryIcon = 'categories/' . $categoryImageName;

            if (!is_null($request->old_icon)) {
                Helper::deleteOldImageBase('categories/' . $request->old_icon);
            }
            Helper::putImageToUploadsBaseFolder($categoryIcon, $request->icon);
        };
        $data = [
            'name' => $request->name,
            'link' => $link,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'icon' => $categoryImageName,
        ];

        $this->category->update($id, $data);

        $notification = [
            'message' => __('Update category successfully!'),
            'alert-type' => 'success',
        ];
            
        return redirect()->route('categories.index')->with($notification);
    }

    public function subCreate($id)
    {
        $parentCategory = $this->category->findOrFail($id);
        $wishlist = $this->wishlist->all();
        $users = $this->user->all();
        $posts = $this->post->all();
        $recipes = $this->recipe->getAllRecipeDesc(config('manual.pagination.recipe'), ['level']);
        $optionParentCategory = $this->category->getOptionParentCategories();

        return view('admin.categories.addSub', compact(
            'parentCategory',
            'optionParentCategory',
            'recipes',
            'wishlist',
            'users',
            'posts'
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->category->destroy($id);

        $notification = [
            'message' => __('Delete Category Successfully!'),
            'alert-type' => 'warning',
        ];

        return redirect()->route('categories.index')->with($notification);
    }
}
