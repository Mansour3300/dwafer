<?php

namespace App\Http\Controllers\Home;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Home\ProjectResource;
use App\Http\Resources\Home\OneProjectResource;

class HomeProjectController extends Controller
{
    public function index()
    {
        $Projects = Project::all();
        $resource = ProjectResource::collection($Projects);
        return response()->json(['status'=>'success','data'=>$resource,'message'=>'']);
    }

    public function show($id)
    {
        $Project = Project::findorfail($id);
        $resource = OneProjectResource::make($Project);
        return response()->json(['status'=>'success','data'=>$resource,'message'=>'']);
    }
}
