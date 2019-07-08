<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Constracts\Eloquent\CategoryRepository;
use App\Constracts\Eloquent\RecipeRepository;
use App\Constracts\Eloquent\UserRepository;
use App\Constracts\Eloquent\LevelRepository;
use App\Notifications\GiftNotification;
use App\Models\Gift;
use App\Helpers\Helper;
use Carbon\Carbon;

use Redirect;
use Auth;
use DB;

class GiftController extends Controller
{
    protected $category;
    protected $recipe;
    protected $user;
    protected $level;

    public function __construct(
        CategoryRepository $category,
        RecipeRepository $recipe,
        LevelRepository $level,
        UserRepository $user
    ) {
        $this->category = $category;
        $this->recipe = $recipe;
        $this->user = $user;
        $this->level = $level;
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
        $gifts = Gift::paginate(10);

        return view('frontend.gifts.index', compact(
            'categories',
            'gifts'
        ));
    }

    public function confirmForm($id)
    {
        $categories = $this->getCategoriesForNav();
        $user = Auth::user();
        $gift = Gift::findOrFail($id);

        return view('frontend.gifts.confirm', compact(
            'categories',
            'user',
            'gift'
        ));
    }

    public function takeGift(Request $request, $id)
    {
        $validatedData = $request->validate([
            'phone' => 'required|max:12',
            'address' => 'required',
        ]);

        $user = Auth::user();
        $gift = Gift::findOrFail($id);

        if ($user->star_num >= $gift->star_point) {
            $data = [
                'user_id' => $user->id,
                'gift_id' => $id,
                'phone' => $request->phone,
                'address' => $request->address,
                'created_at' => Carbon::now()->toDateTimeString()
            ];
            $quantity = $gift->quantity;
    
            DB::table('gift_user')->insert($data);

            $gift->quantity = $quantity - 1;
            $gift->save();
            
            $user->star_num = $user->star_num - $gift->star_point;
            $user->save();

            $notification = [
                'message' => __('Your exchange are on process. We will tell you when we ship the good'),
                'alert-type' => 'success',
            ];

            $user->notify(new GiftNotification($gift));
        } else {
            $notification = [
                'message' => __('You do not have enough star for changing this gift. Please take anothers'),
                'alert-type' => 'warning',
            ];
        }
        

        return redirect()->route('gift.list')->with($notification);
    }
}
