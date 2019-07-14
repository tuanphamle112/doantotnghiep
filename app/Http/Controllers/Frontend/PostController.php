<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Constracts\Eloquent\CategoryRepository;
use App\Constracts\Eloquent\UserRepository;
use App\Constracts\Eloquent\PostRepository;
use App\Http\Requests\CreatePostRequest;

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
        $allPostActive = $this->post->getAllPostActive(['comments'], config('manual.pagination.post'));

        return view('frontend.posts.index', compact(
            'categories',
            'allPostActive'
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
        $allCategories = $this->category->all();

        return view('frontend.posts.create', compact(
            'categories',
            'allCategories'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        $postImageName = null;
        if ($request->categories == null) {
            return redirect()->back()->withErrors(['categories' => __('Please take at least one category')]);
        }

        if (!is_null($request->main_image)) {
            $postImageName = time() . $request->main_image->getClientOriginalName();
            $postImage = 'posts/' . $postImageName;

            Helper::putImageToUploadsBaseFolder($postImage, $request->main_image);
        }
        $data = [
            'image' => $postImageName,
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'user_id' => Auth::user()->id,
            'status' => config('manual.post_status.Pending'),
        ];

        $post = $this->post->create($data);

        $post->category()->sync($request->categories);

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
        $post = $this->post->findOrFail($id);
        $createdAtPost = $post->created_at->format('Y-m-d');
        $categories = $this->getCategoriesForNav();
        $convertedContent =  html_entity_decode($post->content, ENT_COMPAT, 'UTF-8');
        $porpularPost = $this->post->getPopularPostForHomepage();
        $comments = $post->comments;
        return view('frontend.posts.detail', compact(
            'post',
            'categories',
            'createdAtPost',
            'convertedContent',
            'porpularPost',
            'comments'
        ));
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

    public function myPostIndex()
    {
        $categories = $this->getCategoriesForNav();
        $myPosts = $this->post->getAllPostsOfOneUser(config('manual.pagination.post'), Auth::user()->id, ['comments']);

        return view('frontend.posts.my-posts.index', compact(
            'categories',
            'myPosts'
        ));
    }

    public function myPostEdit($id)
    {
        $post = $this->post->findOrFail($id);

        $categories = $this->getCategoriesForNav();
        $allCategories = $this->category->all();
        $postCategories = $post->category;

        return view('frontend.posts.my-posts.edit', compact(
            'categories',
            'allCategories',
            'post',
            'postCategories'
        ));
    }

    public function myPostUpdate(CreatePostRequest $request, $id)
    {
        $post =$this->post->findOrFail($id);

        $postImageName = $request->post_image_old;
        if ($request->categories == null) {
            return redirect()->back()->withErrors(['categories' => __('Please take at least one category')]);
        }

        if (!is_null($request->main_image)) {
            $postImageName = time() . $request->main_image->getClientOriginalName();
            $postImage = 'posts/' . $postImageName;

            if (!is_null($request->post_image_old)) {
                Helper::deleteOldImageBase('posts/' . $request->post_image_old);
            }

            Helper::putImageToUploadsBaseFolder($postImage, $request->main_image);
        }
        $data = [
            'image' => $postImageName,
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'status' => config('manual.post_status.Pending'),
        ];

        $this->post->update($id, $data);
        $post->category()->sync($request->categories);

        $notification = [
            'message' => __('Update Post successfully!'),
            'alert-type' => 'success',
        ];

        return redirect()->route('posts.show', [$post->id])->with($notification);
    }

    public function myPostDelete($id, Request $request)
    {
        $post = $this->post->findOrFail($id);
        Helper::deleteOldImageBase('posts/' . $request->post_image);
        $post->category()->detach();
        
        $this->post->destroy($id);

        $notification = [
            'message' => __('Delete post successfully!'),
            'alert-type' => 'warning',
        ];

        return redirect()->route('my-posts.index')->with($notification);
    }
}
