<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Constracts\Eloquent\CategoryRepository;
use App\Constracts\Eloquent\UserRepository;
use App\Constracts\Eloquent\PostRepository;

use App\Helpers\Helper;
use Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */


    protected $category;
    protected $user;
    protected $post;

    public function __construct(
        CategoryRepository $category,
        UserRepository $user,
        PostRepository $post
    ) {
        $this->category = $category;
        $this->user = $user;
        $this->post = $post;
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

        return view('frontend.posts.index', compact(
            'categories'
        ));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->getCategoriesForNav();

        return view('frontend.posts.create', compact(
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
        $postName = '';
        if (!is_null($request->main_image)) {
            $postImageName = time() . $request->main_image->getClientOriginalName();
            $postImage = 'posts/' . $postImageName;

            if (!is_null($request->post_image_old)) {
                Helper::deleteOldImageBase('posts/' . $request->post_image_old);
            }

            Helper::putImageToUploadsBaseFolder($postImage, $request->main_image);
        }
        $data = [
            'image' => $postName,
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'user_id' => Auth::user()->id,
            'status' => config('manual.post_status.Pending'),
        ];

        $post = $this->post->create($data);

        $notification = [
            'message' => __('Create Post successfully!'),
            'alert-type' => 'success',
        ];

        return redirect()->route('posts.show', [$post->id])->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return 'xxx';
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
        //
    }
}
