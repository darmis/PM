@extends('layouts.app')

@section('content')
<div class="justify-content-center">
    <div class="card">
        <div class="card-header text-center text-uppercase">{{ __($name) }}</div>

        <div class="card-body">
            @if(count($timings))
                <table class="table table-sm table-hover table-striped">
                    <tr>
                        <th>ID</th>
                        <th>{{ __('Project') }}</th>
                        <th>{{ __('Task') }}</th>
                        <th>{{ __('Start time') }}</th>
                        <th>{{ __('End time') }}</th>
                        <th>{{ __('Time spent') }}</th>
                        <th>{{ __('Note') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    @foreach($timings as $timing)
                    <tr>
                        <td><a href="{{ url('/timing') }}/{{ $timing->id }}">{{ $timing->id }}</a></td>
                        <td><a href="{{ url('/project') }}/{{ $timing->task->project->id }}">{{ Str::limit($timing->task->project->name, 30) }}</a></td>
                        <td><a href="{{ url('/task') }}/{{ $timing->task->id }}">{{ Str::limit($timing->task->name, 30) }}</a></td>
                        <td>{{ $timing->start_time }}</td>
                        <td>{{ $timing->end_time }}</td>
                        <td>{{ $timing->timespent }}</td>
                        <td>{{ $timing->note }}</td>
                        <td>
                            <div class="row">
                                <span><a href="{{ url('/timing') }}/{{ $timing->id }}" class="btn btn-primary btn-sm"><i class="fa fa-search"></i></a></span>
                            @if(Auth::user()->isAdmin)
                                <span><a href="{{ url('/timing') }}/{{ $timing->id }}/edit" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a></span>
                                <span>
                                    <form method="POST" action="{{ url('/timing') }}/{{ $timing->id }}">
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
                {{$timings->links()}}
            @endif
        </div>
    </div>
</div>


@endsection
