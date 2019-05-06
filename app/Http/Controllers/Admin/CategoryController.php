<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Constracts\Eloquent\CategoryRepository;
use App\Http\Requests\CreateCategoryRequest;
use App\Helpers\Helper;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        $categories = [];
        $categoryParents = $this->category->getParentCategoriesPaginate(config('manual.pagination.category'));
        
        foreach ($categoryParents as $categoryParent) {
            $parent_id = $categoryParent->id;
            $categoryChildren = $this->category->getChildrenCategories($parent_id);

            $categoryParent->children = $categoryChildren;
            $categories[] = $categoryParent;
        }
        $data['categories'] = $categories;
        $data['categoryParents'] = $categoryParents; //Paginate

        return view('admin.categories.index', compact('data'));
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
    public function store(CreateCategoryRequest $request)
    {
        $link = changeLink($request->link);
        $data = [
            'name' => $request->name,
            'link' => $link,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
        ];

        $this->category->create($data);

        $notification = [
            'message' => __('Create category successfully!'),
            'alert-type' => 'success',
        ];
            
        return redirect()->route('categories.index')->with($notification);
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
        $category = $this->category->findOrFail($id);

        $optionParentCategory = $this->category->getOptionParentCategories();

        return view('admin.categories.update', compact(
            'category',
            'optionParentCategory'
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
        $link = changeLink($request->link);

        $data = [
            'name' => $request->name,
            'link' => $link,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
        ];

        $this->category->update($id, $data);

        $notification = [
            'message' => __('Update category successfully!'),
            'alert-type' => 'success',
        ];
            
        return redirect()->route('categories.index')->with($notification);
    }

    public function subCreate($id)
    {
        $parentCategory = $this->category->findOrFail($id);

        $optionParentCategory = $this->category->getOptionParentCategories();

        return view('admin.categories.addSub', compact(
            'parentCategory',
            'optionParentCategory'
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->category->destroy($id);

        $notification = [
            'message' => __('Delete Category Successfully!'),
            'alert-type' => 'warning',
        ];

        return redirect()->route('categories.index')->with($notification);
    }
}
