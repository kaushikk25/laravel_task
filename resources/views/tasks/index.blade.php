@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="card-header">Project Task List </h4>
                        <a class="btn btn-primary float-right" href="{{ route('task.create') }}">Add New Task</a>
                    <div class="card-body">

                        <div class="row">
                        @foreach ($projects as $key => $project)
                            <div class="col-sm-3 mb-2">
                            <table class="taskTable table table-bordered table-hover mt-2">
                                <thead>
                                    <tr>
                                        <th>{{ $project->name }}</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="sortRow">
                                    @php
                                    $tasks = App\Task::whereProject_id($project->id)->orderBy('position')->get();
                                    @endphp
                                    @foreach ($tasks as $key => $task)
                                        <tr data-index="{{ $task->id }}" data-position="{{ $task->position }}">
                                            <td class="move-task">{{ $task->name }}</td>
                                            <td>
                                                <a class="text-muted ml-2" title="Edit Task" href="{{ route('task.edit', ['id' => encrypt($task->id)]) }}" ><i class="fa fa-edit" style="font-size:20px"></i></a>
                                                <a class="ml-2 text-muted delete_task" title="Delete Task" href="" id="{{encrypt($task->id)}}"> <i class="fa fa-trash-o" style="font-size:20px"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('exernal_Js')

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.taskTable .sortRow').sortable({
                update: function(event, ui) {
                    $(this).children().each(function(index) {
                        if ($(this).attr('data-position') != (index + 1)) {
                            $(this).attr('data-position', (index + 1)).addClass('updated');
                        }
                    });
                    updateNewPositions();
                }
            });
        });

        /** update new task position**/
        function updateNewPositions() {
            var positions = [];
            $('.updated').each(function() {
                positions.push([$(this).attr('data-index'),
                $(this).attr('data-position')]);
                $(this).removeClass('updated');
            });

            $.ajax({
                url: '{{ route('update.task.position') }}',
                method: 'PUT',
                dataType: 'json',
                data: {
                    positions: positions,
                    _token: '{{ csrf_token() }}'
                },
            });
        }

        /** delete task **/
        $(document).on('click', '.delete_task', function() {
            if (confirm("Are you sure delete task?")) {
                var id = $(this).attr('id');
                $.ajax({
                    url: "{{route('task.delete')}}",
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
