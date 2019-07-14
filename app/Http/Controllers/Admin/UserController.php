<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Constracts\Eloquent\UserRepository;
use App\Http\Requests\UsersRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Constracts\Eloquent\RecipeRepository;
use App\Constracts\Eloquent\LevelRepository;
use App\Constracts\Eloquent\CategoryRepository;
use App\Constracts\Eloquent\WishlistRepository;
use App\Constracts\Eloquent\PostRepository;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $user;
    protected $recipe;
    protected $level;
    protected $category;
    protected $wishlist;
    protected $post;

    public function __construct(
        UserRepository $user,
        RecipeRepository $recipe,
        LevelRepository $level,
        WishlistRepository $wishlist,
        CategoryRepository $category,
        PostRepository $post
        ) {
        $this->user = $user;
        $this->recipe = $recipe;
        $this->level = $level;
        $this->category = $category;
        $this->wishlist = $wishlist;
        $this->post = $post;
    }

    public function index()
    {
        $users = $this->user->paginate(config('manual.pagination.user'));
        $recipes = $this->recipe->getAllRecipeDesc(config('manual.pagination.recipe'), ['level']);
        $wishlist = $this->wishlist->all();
        $posts = $this->post->all();

        return view('admin.users.index', compact(
            'users',
            'recipes',
            'wishlist',
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
    public function store(UsersRequest $request)
    {
        $inputPassword = $request->password;

        $userInfor = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'permission' => $request->permission,
            'gender' => $request->gender,
            'password' => Hash::make($inputPassword),
        ];

        $this->user->create($userInfor);
        
        $notification = [
            'message' => __('Create user successfully!'),
            'alert-type' => 'success',
        ];
            
        return redirect()->route('users.index')->with($notification);
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
        $user = $this->user->findOrFail($id);

        $users = $this->user->paginate(config('manual.pagination.user'));
        $recipes = $this->recipe->getAllRecipeDesc(config('manual.pagination.recipe'), ['level']);
        $wishlist = $this->wishlist->all();
        $posts = $this->post->all();

        return view('admin.users.update', compact(
            'user',
            'users',
            'recipes',
            'wishlist',
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
    public function update(UserUpdateRequest $request, $id)
    {
        $this->user
            ->findOrFail($id)
            ->update($request->all());

        $notification = [
            'message' => __('Update user successfully!'),
            'alert-type' => 'success',
        ];

        return redirect()->route('users.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->user->destroy($id);

        $notification = [
            'message' => __('Delete user successfully!'),
            'alert-type' => 'warning',
        ];

        return redirect()->route('users.index')->with($notification);
    }
}
