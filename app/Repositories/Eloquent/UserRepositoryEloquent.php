<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepositoryEloquent;
use App\Constracts\Eloquent\UserRepository;

use App\User;

class UserRepositoryEloquent extends BaseRepositoryEloquent implements UserRepository
{
    public $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getFeatureMember($with = [], $select = ['*'])
    {
        $user = $this->model
        ->with($with)
        ->where('permission', config('manual.permission.user'))
        ->orderBy('star_num', 'DESC')
        ->firstOrFail();
        
        return $user;
    }
    public function getFeatureMemberList($with = [], $select = ['*'])
    {
        $user = $this->model
        ->with($with)
        ->where('permission', config('manual.permission.user'))
        ->orderBy('star_num', 'DESC')
        ->take(5)
        ->get();
        
        return $user;
    }

    public function getNewestStarPoint($id, $point = 0)
    {
        $user = $this->model->findOrFail($id);

        return $user->update(['star_num' => $point]);
    }
}
