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

    public function getParentCategoriesPaginate($paginate)
    {
        return $this->model->where('parent_id', null)->paginate($paginate);
    }

    public function getAllParentCategories()
    {
        return $this->model->where('parent_id', null)->get();
    }

    public function getChildrenCategories($parentId)
    {
        return $this->model->where('parent_id', $parentId)->get();
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

    public function getParentCategoryByLink($link)
    {
        return $this->model->where('link', $link)->whereNull('parent_id');
    }

    public function getSubCategoryByParentId($parentId)
    {
        return $this->model->where('parent_id', $parentId);
    }

    public function getSubCategoryByLink($link, $parentId)
    {
        return $this->model->where('link', $link)->where('parent_id', $parentId);
    }

    public function getAllRecipeIdByCategory($listCateId)
    {
        return $this->model->whereIn('id', $listCateId)->get()->load(['recipe']);
    }

    public function getRecipeBySubCategory($parentId, $subcateId)
    {
        return $this->model
        ->where('id', $subcateId)
        ->where('parent_id', $parentId)
        ->firstOrFail()
        ->load(['recipe']);
    }
}
