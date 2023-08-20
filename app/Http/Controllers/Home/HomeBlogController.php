<?php

namespace App\Http\Controllers\Home;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Home\BlogResource;

class HomeBlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::paginate(5);
        $resource = BlogResource::collection($blogs);
        return response()->json(['status'=>'success','data'=>$resource,'message'=>'']);
    }


    public function show($id)
    {
        $blogs = Blog::findorfail($id);
        $resource = BlogResource::make($blogs);
        return response()->json(['status'=>'success','data'=>$blogs,'message'=>'']);
    }
}

