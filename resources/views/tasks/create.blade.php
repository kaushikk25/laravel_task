@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Create Task</div>

                <div class="card-body">
                    <form action="{{ route('task.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 mt-2">
                                <label for="task">Task Name</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" value="{{ old('task') }}" name="task" id="task" placeholder="Enter Task Name" required/>
                                @error('task')
                                    <span class="text-danger">{{ $message }}<span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-3 mt-2">
                                <label for="project">Select Project</label>
                            </div>
                            <div class="col-md-9">
                                {{-- <selece type="text" class="form-control" value="{{ old('task') }}" name="task" id="task" placeholder="Enter Task Name" required/> --}}
                                <select class="form-control" name="project" id="project" required>
                                    <option value="">Select Project</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                                @error('project')
                                    <span class="text-danger">{{ $message }}<span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="form-group float-right">
                                    <input type="submit" class="btn btn-primary"   value="Save">
                                    <a href="{{ route('task') }}" class="btn btn-danger">Cancel</a>
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
