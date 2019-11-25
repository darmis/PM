@extends('layouts.app')

@section('content')
<link href='{{ asset('storage/packages/kanban/jkanban.min.css') }}' rel='stylesheet' />
<div class="justify-content-center">
    <div class="card">
        <div class="card-header text-center text-uppercase">{{ __($name) }}</div>

        <div class="card-body">
            <div class="view-buttons text-right">
                <button id="list-view-button" class="btn btn-sm secondary" disabled>List</button>
                <button id="kanban-view-button" class="btn btn-sm color-o">Kanban</button>
            </div>
            <h3>
                @if(Auth::user()->isAdmin)
                    <div class="text-left"><a href="/task/create" class="btn btn-success btn-sm">{{ __('Create a new task') }}</a></div>
                @endif
            </h3>
            <div class="list-view">

                @if(count($tasks))
                    <table class="table table-sm table-hover table-striped">
                        <tr>
                            <th>ID</th>
                            <th>{{ __('Project') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Start date') }}</th>
                            <th>{{ __('Deadline') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Creator') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                        @foreach($tasks as $task)
                        <tr>
                            <td><a href="{{ url('/task') }}/{{ $task->id }}">{{ $task->id }}</a></td>
                            <td><a href="{{ url('/project') }}/{{ $task->project->id }}">{{ Str::limit($task->project->name, 30) }}</a></td>
                            <td><a href="{{ url('/task') }}/{{ $task->id }}">{{ Str::limit($task->name, 30) }}</a></td>
                            <td>{{ $task->startdate }}</td>
                            <td>{{ $task->deadline }}</td>
                            <td>{{ $task->status }}</td>
                            <td>
                                @foreach ($users as $user)
                                    @if($user->id == $task->creator)
                                        {{ $user->name }} {{ $user->lastname }}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <div class="row">
                                    <span><a href="{{ url('/task') }}/{{ $task->id }}" class="btn btn-primary btn-sm"><i class="fa fa-search"></i></a></span>
                                @if(Auth::user()->isAdmin)
                                    <span><a href="{{ url('/task') }}/{{ $task->id }}/edit" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a></span>
                                    <span>
                                        <form method="POST" action="{{ url('/task') }}/{{ $task->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </span>
                                @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    {{$tasks->links()}}
                @endif
            </div>
            <div class="kanban-view hidden">
                <div class="kanban-container">

                </div>
            </div>
        </div>
    </div>
</div>
<script src='{{ asset('storage/packages/kanban/jkanban.min.js') }}'></script>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //list-kanban view
        $('#list-view-button').on('click', listView);
        $('#kanban-view-button').on('click', kanbanView);

        function kanbanView() {
            $('#list-view-button').prop('disabled', false);
            $('#kanban-view-button').prop('disabled', true);
            $('#kanban-view-button').removeClass('color-o');
            $('#kanban-view-button').addClass('secondary');
            $('#list-view-button').removeClass('secondary');
            $('#list-view-button').addClass('color-o');
            $('.kanban-view').removeClass('hidden');
            $('.list-view').addClass('hidden');
        }

        function listView() {
            $('#list-view-button').prop('disabled', true);
            $('#kanban-view-button').prop('disabled', false);
            $('#list-view-button').removeClass('color-o');
            $('#list-view-button').addClass('secondary');
            $('#kanban-view-button').removeClass('secondary');
            $('#kanban-view-button').addClass('color-o');
            $('.list-view').removeClass('hidden');
            $('.kanban-view').addClass('hidden');
        }

        var KanbanTest = new jKanban({
            element: '.kanban-container',
            responsivePercentage: true,
            dropEl: function (el, target, source, sibling) {
                $.ajax({
                    type: "get",
                    url: "{{ route('updateStatus') }}",
                    data: {
                        newStatus: target.parentNode.getAttribute("data-id"),
                        taskID: el.getAttribute('data-eid')
                    }
                });
            },
            boards  :[
                {
                    'id' : '_notstarted',
                    'title'  : 'Not started yet',
                    'class' : 'color-g,text-center,text-w',
                    'item'  : [
                        @if(!empty($tasks))
                            @foreach($tasks as $task)
                                @if($task->status == 'Not started yet')
                                {
                                id: '{{ $task->id }}',
                                title: '{{ $task->name }}'
                                },
                                @endif
                            @endforeach
                        @endif
                    ]
                },
                {
                    'id' : '_progress',
                    'title'  : 'In progress',
                    'class' : 'color-b,text-center,text-w',
                    'item'  : [
                        @if(!empty($tasks))
                            @foreach($tasks as $task)
                                @if($task->status == 'In progress')
                                {
                                id: '{{ $task->id }}',
                                title: '{{ $task->name }}'
                                },
                                @endif
                            @endforeach
                        @endif
                    ]
                },
                {
                    'id' : '_done',
                    'title'  : 'Done',
                    'class' : 'color-o,text-center,text-w',
                    'item'  : [
                        @if(!empty($tasks))
                            @foreach($tasks as $task)
                                @if($task->status == 'Done')
                                {
                                id: '{{ $task->id }}',
                                title: '{{ $task->name }}'
                                },
                                @endif
                            @endforeach
                        @endif
                    ]
                }
            ]
        });
    });
</script>

@endsection
