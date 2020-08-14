<?php

namespace App\Http\Controllers;

use App\Task;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TasksController extends Controller
{
    public function index()
    {
        $projects = Project::get();
        return view('tasks.index', ['projects' => $projects]);
    }

    public function create()
    {
        $projects = Project::get();
        return view('tasks.create', ['projects' => $projects]);
    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'task' => 'required',
            'project' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $task = array();
        $task['name'] = $request->task;
        $task['project_id'] = $request->project;
        $task['position'] = Task::whereProject_id($request->project)->max('position')+1;
        Task::create($task);
        return redirect()->route('task');
    }

    public function edit($id)
    {
        $task = Task::findOrFail(decrypt($id));
        $projects = Project::get();
        return view('tasks.edit', ['task' => $task,'projects' => $projects]);
    }

    public function update(Request $request, $id)
    {
        try {
            $validator=Validator::make($request->all(),[
                'task' => 'required',
                'project' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }
            $params = array();
            $params['name'] = $request->task;
            $params['project_id'] = $request->project;

            Task::whereId(decrypt($id))->update($params);

            return redirect()->route('task');
        } catch (\Throwable $th) {
            return redirect()->route('task');
        }
    }

    public function delete(Request $request)
    {
        $delete_task = Task::where('id', '=', decrypt($request->table_id))->delete();
        if($delete_task){
            return "SuccessFullyDelete";
        }else{
            return "Error";
        }
    }

    public function updatePosition(Request $request)
    {
        $request->validate([
            'positions'=>'required'
        ]);

        foreach ($request->positions as $position){
            $UpdatePosition = Task::find($position[0]);
            $UpdatePosition->position =  $position[1];
            $UpdatePosition->save();
        }

        return response()->json('success');
    }
}
