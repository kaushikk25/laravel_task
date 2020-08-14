<?php

namespace App\Http\Controllers;

use App\Task;
use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::get();
        return view('project.index', ['projects' => $projects]);
    }

    public function create()
    {
        return view('project.craete');
    }

    public function store(Request $request)
    {
        try {
            $validator=Validator::make($request->all(),[
                'project' => ['required', 'unique:projects,name']
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }

            $project = new Project();
            $project->name = $request->project;
            $project->user_id = Auth::user()->id;

            $project->save();

            return redirect()->route('project');
        } catch (\Throwable $th) {
            return redirect()->route('project');
        }
    }

    public function edit($id)
    {
        $project = Project::findOrFail(decrypt($id));
        return view('project.edit', ['project' => $project]);
    }

    public function update(Request $request, $id)
    {
        try {
            $validator=Validator::make($request->all(),[
                'project' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }
            $params = array();
            $params['name'] = $request->project;
            Project::whereId(decrypt($id))->update($params);

            return redirect()->route('project');
        } catch (\Throwable $th) {
            return redirect()->route('project');
        }
    }

    public function delete(Request $request)
    {
        Task::whereProject_id(decrypt($request->table_id))->delete();
        $delete_project = Project::whereId(decrypt($request->table_id))->delete();
        if($delete_project){
            return "SuccessFullyDelete";
        }else{
            return "Error";
        }
    }

}
