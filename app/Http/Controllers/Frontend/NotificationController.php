<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Constracts\Eloquent\CategoryRepository;
use App\Constracts\Eloquent\UserRepository;
use App\Models\Follow;
use App\Helpers\Helper;
use Auth;
use Hash;

class NotificationController extends Controller
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

    public function index()
    {
        $categories = $this->getCategoriesForNav();
        if (Auth::check()) {
            $user = Auth::user();
            $notifications = $user->notifications()->paginate(5);
            $unreadNotifications = $user->unreadNotifications()->paginate(5);
            $notificationsNum = count($user->unreadNotifications);
            $following = Follow::where('user_id_follow', $user->id)->with('getUserBeFollow')->paginate(8);
            $follower = Follow::where('user_id', $user->id)->with('getUserFollowing')->paginate(8);
        }

        return view('frontend.notifications.index', compact(
            'categories',
            'user',
            'notifications',
            'unreadNotifications',
            'notificationsNum',
            'following',
            'follower'
        ));
    }

    public function show($id)
    {
        if (Auth::check()) {
            $notification = Auth::user()->notifications()->where('id', $id)->first();
            if ($notification) {
                $notification->markAsRead();
                if ($notification->type == 'App\Notifications\RecipeNotification') {
                    return redirect()->route('detail-recipe', [changeLink($notification->data['name']), $notification->data['id']]);
                }
                if ($notification->type == 'App\Notifications\GiftNotification') {
                    return redirect()->route('gift.list');
                }
                if ($notification->type == 'App\Notifications\PostNotification') {
                    return redirect()->route('posts.show', $notification->data['id']);
                }
            }
        }
    }
}
