<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Resources\Home\CategoryResource;
use App\Http\Resources\Home\OneCategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $resource = CategoryResource::collection($categories);
        return response()->json(['status'=>'success','data'=>$resource]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $new_category = $request->validated();
        $new_category['category_image']=$request->file('category_image')->store('image','public');
        Category::create($new_category);
        return response()->json(['status'=>'success','message'=>'you just added new category']);
    }

     /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findorfail($id);
        $resource = OneCategoryResource::make($category);
        return response()->json(['status'=>'success','data'=>$resource]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $request->validated();
        $category = Category::findorfail($id);
        $category->update([
            'category_image'=>$request->file('category_image')->store('image','public'),
            'category_name'=>$request->category_name
        ]);
        return response()->json(['status'=>'success','message'=>'you just updated category']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category_image = Category::findorfail($id)->category_image;
        $category = Category::findorfail($id);
        unlink(storage_path('app/public/'.$category_image));
        $category->delete();
        return response()->json(['status'=>'success','message'=>'category just deleted']);
    }
}