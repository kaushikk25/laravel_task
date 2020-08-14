@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Edit Project</div>

                <div class="card-body">
                    <form action="{{ route('project.update', ['id' => encrypt($project->id)]) }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 mt-2">
                                <label for="task">Project Name</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" value="{{ $project->name }}" name="project" id="project" placeholder="Enter Project Name" required/>
                                @error('task')
                                    <span class="text-danger">{{ $message }}<span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="form-group float-right">
                                    <input type="submit" class="btn btn-primary"   value="Update">
                                    <a href="{{ route('project') }}" class="btn btn-danger">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
