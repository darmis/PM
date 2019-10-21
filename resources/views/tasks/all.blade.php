@extends('layouts.app')

@section('content')
<div class="justify-content-center">
    <div class="card">
        <div class="card-header text-center text-uppercase">{{ __($name) }}</div>

        <div class="card-body">
            <h3>
                @if(Auth::user()->isAdmin)
                    <span class="float-left"><a href="/task/create" class="btn btn-success btn-sm">{{ __('Create a new task') }}</a></span>
                @endif
            </h3>
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
    </div>
</div>


@endsection
