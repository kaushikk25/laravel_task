@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Create Projects</div>

                <div class="card-body">
                    <form action="{{ route('project.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 mt-2">
                                <label for="project">Project Name</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" value="{{ old('project') }}" name="project" id="project" placeholder="Enter Project Name" required/>
                                @error('project')
                                    <span class="text-danger">{{ $message }}<span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="form-group float-right">
                                    <input type="submit" class="btn btn-primary"   value="Save">
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
