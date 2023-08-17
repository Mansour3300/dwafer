<?php

namespace App\Http\Controllers\Admin;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubCategoryRequest;
use App\Http\Resources\Home\SubCategoryResource;
use App\Http\Resources\Home\OneSubCategoryResource;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sub_categories = SubCategory::all();
        $resource = SubCategoryResource::collection($sub_categories);
        return response()->json(['status'=>'success','data'=>$resource]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubCategoryRequest $request)
    {
        $new_sub_category = $request->validated();
        $new_sub_category['sub_category_image']=$request->file('sub_category_image')->store('image','public');
        SubCategory::create($new_sub_category);
        return response()->json(['status'=>'success','message'=>'you just added new sub category']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sub_category = Subcategory::findorfail($id);
        $resource = OneSubCategoryResource::make($sub_category);
        return response()->json(['status'=>'success','data'=>$resource]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubCategoryRequest $request, string $id)
    {
        $request->validated();
        $category = SubCategory::findorfail($id);
        $category->update([
            'sub_category_image'=>$request->file('sub_category_image')->store('image','public'),
            'sub_category_name'=>$request->sub_category_name
        ]);
        return response()->json(['status'=>'success','message'=>'you just updated sub category']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sub_category_image = SubCategory::findorfail($id)->sub_category_image;
        $sub_category = SubCategory::findorfail($id);
        unlink(storage_path('app/public/'.$sub_category_image));
        $sub_category->delete();
        return response()->json(['status'=>'success','message'=>'category just deleted']);
    }
}
