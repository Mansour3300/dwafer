<?php

namespace App\Http\Controllers\Provider;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Home\ProjectResource;
use App\Http\Requests\Provider\ProjectRequest;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('provider_id',auth()->guard('developer')->id())
                      ->get();
                      $resource = ProjectResource::collection($projects);
        return response()->json(['status'=>'success','data'=>$resource,'message'=>'']);
    }


    public function store(ProjectRequest $request)
    {
        $new_project = $request->validated();
        $new_project['provider_id']=auth()->guard('developer')->id();
        $new_project['project_image']=$request->file('project_image')->store('image','public');
        Project::create($new_project);
        return response()->json(['status'=>'success','data'=>null,'message'=>'you just created new project successfully']);
    }


    public function show(string $id)
    {
        $project = Project::where('provider_id',auth()->guard('developer')->id())->findorfail($id);
        $resource = ProjectResource::make($project);
        return response()->json(['status'=>'success','data'=>$resource,'message'=>'']);
    }


    public function update(ProjectRequest $request, string $id)
    {
        $request->validated();
        $project = Project::where('provider_id',auth()->guard('developer')->id())->findorfail($id);
        $project->update([
            'project_image'=>$request->file('project_image')->store('image','public'),
            'project_name'=>$request->project_name,
            'project_discreption'=>$request->project_discreption
        ]);
        return response()->json(['status'=>'success','data'=>null,'message'=>'you just updated project successfully']);
    }


    public function destroy(string $id)
    {
        $project_image = Project::findorfail($id)->project_image;
        $project = Project::findorfail($id);
        unlink(storage_path('app/public/'.$project_image));
        $project->delete();
        return response()->json(['status'=>'success','data'=>null,'message'=>'project just deleted']);
    }
}
