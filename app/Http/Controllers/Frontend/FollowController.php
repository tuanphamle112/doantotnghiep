<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Constracts\Eloquent\CategoryRepository;
use App\Constracts\Eloquent\UserRepository;

use App\Models\Recipe;
use Auth;

class FollowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $category;
    protected $user;

    public function __construct(
        CategoryRepository $category,
        UserRepository $user
    ) {
        $this->category = $category;
        $this->user = $user;
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
        Follow::create($request->all());

        return redirect()->back();
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
        //
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
        Follow::destroy($id);

        return redirect()->back();
    }

    public function getFollowing($userId)
    {
        $categories = $this->getCategoriesForNav();
        $user = $this->user->findOrFail($userId);
        $notificationsNum = count($user->unreadNotifications);
        $followStatus = Follow::where('user_id', $userId)->where('user_id_follow', Auth::user()->id)->first();
        $following = Follow::where('user_id_follow', $userId)->with('getUserBeFollow')->paginate(8);
        $follower = Follow::where('user_id', $userId)->with('getUserFollowing')->paginate(8);
        $recipeOfUser = Recipe::where('user_id', $userId)->where('status', config('manual.recipe_status.Actived'))->paginate(8);

        return view('frontend.follows.following', compact(
            'categories',
            'user',
            'followStatus',
            'following',
            'notificationsNum',
            'follower',
            'recipeOfUser'
        ));
    }

    public function getFollower($userId)
    {
        $categories = $this->getCategoriesForNav();
        $user = $this->user->findOrFail($userId);
        $notificationsNum = count($user->unreadNotifications);
        $followStatus = Follow::where('user_id', $userId)->where('user_id_follow', Auth::user()->id)->first();
        $following = Follow::where('user_id_follow', $userId)->with('getUserBeFollow')->paginate(12);
        $follower = Follow::where('user_id', $userId)->with('getUserFollowing')->paginate(12);
        $recipeOfUser = Recipe::where('user_id', $userId)->where('status', config('manual.recipe_status.Actived'))->paginate(8);

        return view('frontend.follows.follower', compact(
            'categories',
            'user',
            'followStatus',
            'following',
            'notificationsNum',
            'follower',
            'recipeOfUser'
        ));
    }

}
