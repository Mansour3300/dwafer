<?php

namespace App\Http\Controllers\Home;

use App\Models\Blog;
use App\Models\Slider;
use App\Models\Project;
use App\Models\Category;
use App\Models\Provider;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\Routing\Alias;
use App\Http\Requests\Home\SearchRequest;
use App\Http\Resources\Home\BlogResource;
use App\Http\Resources\Home\SliderResource;
use App\Http\Resources\Home\ProjectResource;
use App\Http\Resources\Home\CategoryResource;
use App\Http\Resources\Home\ProviderResource;
use App\Http\Resources\Home\AllProviderResource;
use App\Http\Resources\Home\OneSubCategoryResource;

class HomeController extends Controller
{
    public function home(/*SearchRequest $request*/){
        // $request->validated();
        $blogs = Blog::paginate(3);
        $resource1 = BlogResource::collection($blogs);
        $categories = Category::paginate(3);
        $resource2 = CategoryResource::collection($categories);
        $Projects = Project::paginate(5);
        $resource3 = ProjectResource::collection($Projects);
        $providers = Provider::paginate(5);
        $resource4 = AllProviderResource::collection($providers);
        $slider = Slider::paginate(3);
        $resource5 = SliderResource::collection($slider);
        // $search = Provider::where('full_name', 'like','%'.$term. '%')->get();
        // if(count($search)){
        //     $resource6 = AllProviderResource::collection($search);
        return response()->json(['status'=>'success','data'=>['blog'=>$resource1,'category'=>$resource2,'project'=>$resource3,'provider'=>$resource4,'slider'=>$resource5/*,'search'=>$resource6*/],'message'=>''],200);
    }
}


