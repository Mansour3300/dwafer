<?php

namespace App\Http\Controllers\Home;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Home\OneSubCategoryResource;

class HomeSubCategoryController extends Controller
{
    public function show($id)
    {
        $sub_category = SubCategory::findorfail($id);
        $resource = OneSubCategoryResource::make($sub_category);
        return response()->json(['status'=>'success','data'=>$resource,'message'=>'']);
    }
}
