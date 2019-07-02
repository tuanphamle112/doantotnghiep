<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Constracts\Eloquent\CategoryRepository;
use App\Constracts\Eloquent\UserRepository;

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
        $user = Auth::user();
        $notifications = $user->notifications()->paginate(5);
        $unreadNotifications = $user->unreadNotifications()->paginate(5);
        $notificationsNum = count($user->unreadNotifications);

        return view('frontend.notifications.index', compact(
            'categories',
            'user',
            'notifications',
            'unreadNotifications',
            'notificationsNum'
        ));
    }
}
