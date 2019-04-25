<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepositoryEloquent;
use App\Constracts\Eloquent\CategoryRepository;

use App\Models\Category;

class CategoryRepositoryEloquent extends BaseRepositoryEloquent implements CategoryRepository
{
    public $model;

    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    public function getAllParentCategories($paginate)
    {
        return $this->model->where('parent_id', null)->paginate($paginate);
    }

    public function getChildrenCategories($parent_id)
    {
        return $this->model->where('parent_id', $parent_id)->get();
    }

    public function getOptionParentCategories() 
    {
        $categories = $this->model->whereNull('parent_id')->get();
        $result = [];
        foreach ($categories as $category) {
            $result[$category->id] = $category->name;
        }

       	return $result;
    }
}
