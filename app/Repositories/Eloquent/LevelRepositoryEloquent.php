<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepositoryEloquent;
use App\Constracts\Eloquent\LevelRepository;

use App\Models\Level;

class LevelRepositoryEloquent extends BaseRepositoryEloquent implements LevelRepository
{
    public $model;

    public function __construct(Level $level)
    {
        $this->model = $level;
    }
}
