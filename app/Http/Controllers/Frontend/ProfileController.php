<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Constracts\Eloquent\CategoryRepository;
use App\Constracts\Eloquent\UserRepository;
use App\Models\Follow;
use App\Models\Recipe;

use App\Helpers\Helper;
use Auth;
use Hash;

class ProfileController extends Controller
{
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

    public function index($id)
    {
        $categories = $this->getCategoriesForNav();
        $user = $this->user->findOrFail($id);
        $notificationsNum = count($user->unreadNotifications);
        $followStatus = Follow::where('user_id', $user->id)->where('user_id_follow', Auth::user()->id)->first();
        $following = Follow::where('user_id_follow', $id)->with('getUserBeFollow')->paginate(8);
        $follower = Follow::where('user_id', $id)->with('getUserFollowing')->paginate(8);
        $recipeOfUser = Recipe::where('user_id', $id)->where('status', config('manual.recipe_status.Actived'))->paginate(8);

        return view('frontend.profiles.index', compact(
            'categories',
            'user',
            'notificationsNum',
            'followStatus',
            'following',
            'follower',
            'recipeOfUser'
        ));
    }

    public function updateMyAvatar(Request $request, $id)
    {
        if (!is_null($request->avatar)) {
            $avatarName = time() . $request->avatar->getClientOriginalName();
            $avatar = 'avatars/' . $avatarName;

            if (!is_null($request->avatar_old)) {
                Helper::deleteOldImageBase('avatars/' . $request->avatar_old);
            }
            Helper::putImageToUploadsBaseFolder($avatar, $request->avatar);

            $data = [
                'avatar' => $avatarName,
            ];
            $this->user->update($id, $data);
        }
        

        $notification = [
            'message' => __('Update avatar successfully!'),
            'alert-type' => 'success',
        ];

        return redirect()->route('profile.index', [$id])->with($notification);
    }

    public function updateMyInfo(Request $request, $id)
    {
        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'gender' => $request->gender
        ];
        $user = $this->user->findOrFail($id);
        $this->user->update($id, $data);

        $notification = [
            'message' => __('Update user information successfully!'),
            'alert-type' => 'success',
        ];

        return redirect()->route('profile.index', [$id])->with($notification);
    }

    public function showChangePasswordForm()
    {
        $categories = $this->getCategoriesForNav();

        return view('frontend.profiles.changepassword', compact(
            'categories',
            'user'
        ));
    }

    public function changePassword(Request $request)
    {
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);
        
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
        }

        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            return redirect()->back()->with("error", "New Password cannot be same as your current password. Please choose a different password.");
        }

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        $notification = [
            'message' => __('New password set successfully!'),
            'alert-type' => 'success',
        ];

        return redirect()->route('profile.index', [Auth::user()->id])->with($notification);
    }
}
