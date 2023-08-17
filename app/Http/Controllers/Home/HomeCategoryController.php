<?php

namespace App\Http\Controllers\Home;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Home\CategoryResource;
use App\Http\Resources\Home\OneCategoryResource;

class HomeCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $resource = CategoryResource::collection($categories);
        return response()->json(['status'=>'success','data'=>$resource]);
    }

    public function show($id)
    {
        $category = Category::findorfail($id);
        $resource = OneCategoryResource::make($category);
        return response()->json(['status'=>'success','data'=>$resource]);
    }
}
