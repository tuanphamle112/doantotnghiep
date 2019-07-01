<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Constracts\Eloquent\RecipeRepository;
use App\Constracts\Eloquent\LevelRepository;
use App\Constracts\Eloquent\CategoryRepository;
use App\Constracts\Eloquent\WishlistRepository;
use App\Constracts\Eloquent\UserRepository;
use App\Constracts\Eloquent\PostRepository;
use App\Helpers\Helper;
use App\Models\Gift;

use DB;
use Auth;
use Storage;

class GiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $recipe;
    protected $level;
    protected $category;
    protected $wishlist;
    protected $user;
    protected $post;

    public function __construct(
        RecipeRepository $recipe,
        LevelRepository $level,
        WishlistRepository $wishlist,
        CategoryRepository $category,
        UserRepository $user,
        PostRepository $post
    ) {
        $this->recipe = $recipe;
        $this->level = $level;
        $this->category = $category;
        $this->wishlist = $wishlist;
        $this->user = $user;
        $this->post = $post;
    }
    
    public function index()
    {
        $gifts = Gift::paginate(5);
        $recipes = $this->recipe->getAllRecipeDesc(config('manual.pagination.recipe'), ['level']);
        $wishlist = $this->wishlist->all();
        $users = $this->user->all();
        $posts = $this->post->all();

        return view('admin.gifts.index', compact(
            'gifts',
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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:100',
            'description' => 'required|max:500',
            'star_point' => 'required',
            'quantity' => 'required',
            'image' => 'required'
        ]);

        $giftImageName = null;
        if (!is_null($request->image)) {
            $giftImageName = time() . $request->image->getClientOriginalName();
            $giftImage = 'gifts/' . $giftImageName;
            Helper::putImageToUploadsBaseFolder($giftImage, $request->image);
        };
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'star_point' => $request->star_point,
            'quantity' => $request->quantity,
            'image' => $giftImageName,
        ];
        
        Gift::create($data);

        $notification = [
            'message' => __('Create a gift successfully!'),
            'alert-type' => 'success',
        ];
            
        return redirect()->route('gifts.index')->with($notification);
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
        $gift = Gift::findOrFail($id);
        $recipes = $this->recipe->getAllRecipeDesc(config('manual.pagination.recipe'), ['level']);
        $wishlist = $this->wishlist->all();
        $users = $this->user->all();
        $posts = $this->post->all();

        return view('admin.gifts.update', compact(
            'gift',
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
        $validatedData = $request->validate([
            'name' => 'required|max:100',
            'description' => 'required|max:500',
            'star_point' => 'required',
            'quantity' => 'required',
        ]);
        $gift = Gift::findOrFail($id);

        $giftImageName = $gift->image;
        if (!is_null($request->image)) {
            $giftImageName = time() . $request->image->getClientOriginalName();
            $giftImage = 'gifts/' . $giftImageName;
            Helper::deleteOldImageBase('gifts/' . $gift->image);
            Helper::putImageToUploadsBaseFolder($giftImage, $request->image);
        };
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'star_point' => $request->star_point,
            'quantity' => $request->quantity,
            'image' => $giftImageName,
        ];
        
        $gift->update($data);

        $notification = [
            'message' => __('Update a gift successfully!'),
            'alert-type' => 'success',
        ];
            
        return redirect()->route('gifts.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gift = Gift::findOrFail($id);

        Gift::destroy($id);
        Helper::deleteOldImageBase('gifts/' . $gift->image);

        $notification = [
            'message' => __('Delete Gift Successfully!'),
            'alert-type' => 'warning',
        ];

        return redirect()->route('gifts.index')->with($notification);
    }

    public function giftTakeList()
    {
        $takeList = DB::table('gift_user')->orderBy('id', 'DESC')->paginate(5);
        $recipes = $this->recipe->getAllRecipeDesc(config('manual.pagination.recipe'), ['level']);
        $wishlist = $this->wishlist->all();
        $users = $this->user->all();
        $posts = $this->post->all();
        foreach ($takeList as $item) {
            $item->user = $this->user->findOrFail($item->user_id);
            $item->gift = Gift::findOrFail($item->gift_id);
        }

        return view('admin.gifts.take-list', compact(
            'recipes',
            'wishlist',
            'users',
            'posts',
            'takeList'
        ));
    }

    public function giftChangeStatus($id)
    {
        $data = ['status' => config('manual.gift_status.Shipped')];

        DB::table('gift_user')->where('id', $id)->update($data);

        $notification = [
            'message' => __('Exchange are confirmed!'),
            'alert-type' => 'success',
        ];

        return redirect()->route('gift-take.list')->with($notification);
    }
}
