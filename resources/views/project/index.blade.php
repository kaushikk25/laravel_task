@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Projects</div>

                <div class="card-body">
                    <a class="btn btn-primary float-right" href="{{ route('project.create') }}">Add Project</a>
                    <table class="table table-bordered table-hover mt-5">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Project Name</th>
                                <th>Total Task</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $key => $project)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $project->name }}</td>
                                    <td>{{ App\Task::whereProject_id($project->id)->count() }}</td>
                                    <td>
                                        <a class="text-muted ml-2" title="Edit Project" href="{{ route('project.edit', ['id' => encrypt($project->id)]) }}" ><i class="fa fa-edit" style="font-size:20px"></i></a>
                                        <a class="ml-2 text-muted delete_project" title="Delete Project" href="" id="{{encrypt($project->id)}}"> <i class="fa fa-trash-o" style="font-size:20px"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('exernal_Js')

    <script type="text/javascript">

        /** delete project **/
        $(document).on('click', '.delete_project', function() {
            if (confirm("Are you sure delete project?")) {
                var id = $(this).attr('id');
                $.ajax({
                    url: "{{route('project.delete')}}",
                    mehtod: "get",
                    data: { table_id: id, _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        if (response == "SuccessFullyDelete") {
                            location.reload();
                        } else {
                            alert("Something went wrong!!!");
                        }
                    }
                })
            }
        });
    </script>

@endsection
