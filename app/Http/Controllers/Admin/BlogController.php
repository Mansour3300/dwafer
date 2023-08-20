<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogRequest;
use App\Http\Resources\Home\BlogResource;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::paginate(5);
        $resource = BlogResource::collection($blogs);
        return response()->json(['status'=>'success','data'=>$resource,'message'=>'']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        $new_post = $request->validated();
        $new_post['image']=$request->file('image')->store('image','public');
        Blog::create($new_post);
        return response()->json(['status'=>'success','data'=>null,'message'=>'you just created post successfully']);
    }


      /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blog = Blog::findorfail($id);
        $resource = BlogResource::make($blog);
        return response()->json(['status'=>'success','data'=>$resource,'message'=>'']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, string $id)
    {
        $request->validated();
        $post = Blog::findorfail($id);
        $post->update([
            'image'=>$request->file('image')->store('image','public'),
            'blog_name'=>$request->blog_name,
            'blog_discreption'=>$request->blog_discreption
        ]);
        return response()->json(['status'=>'success','data'=>null,'message'=>'you just updated post successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post_image = Blog::findorfail($id)->image;
        $post = Blog::findorfail($id);
        unlink(storage_path('app/public/'.$post_image));
        $post->delete();
        return response()->json(['status'=>'success','data'=>null,'message'=>'post just deleted']);
    }
}
