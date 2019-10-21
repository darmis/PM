@extends('layouts.app')

@section('content')
<div class="justify-content-center">
    <div class="card">
        <div class="card-header text-center text-uppercase">{{ __($name) }}</div>

        <div class="card-body">
            <h3>
                @if(Auth::user()->isAdmin)
                    <span class="float-left"><a href="/project/create" class="btn btn-success btn-sm">{{ __('Create a new project') }}</a></span>
                @endif
            </h3>
            @if(count($projects))
                <table class="table table-sm table-hover table-striped">
                    <tr>
                        <th>ID</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Start date') }}</th>
                        <th>{{ __('Deadline') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Creator') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    @foreach($projects as $project)
                    <tr>
                        <td><a href="{{ url('/project') }}/{{ $project->id }}">{{ $project->id }}</a></td>
                        <td><a href="{{ url('/project') }}/{{ $project->id }}">{{ Str::limit($project->name, 30) }}</a></td>
                        <td>{{ $project->startdate }}</td>
                        <td>{{ $project->deadline }}</td>
                        <td>{{ $project->status }}</td>
                        <td>
                            @foreach ($users as $user)
                                @if($user->id == $project->creator)
                                    {{ $user->name }} {{ $user->lastname }}
                                @endif
                            @endforeach
                        </td>
                        <td>
                            <div class="row">
                                <span><a href="{{ url('/project') }}/{{ $project->id }}" class="btn btn-primary btn-sm"><i class="fa fa-search"></i></a></span>
                            @if(Auth::user()->isAdmin)
                                <span><a href="{{ url('/project') }}/{{ $project->id }}/edit" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a></span>
                                <span>
                                    <form method="POST" action="{{ url('/project') }}/{{ $project->id }}">
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
                {{$projects->links()}}
            @endif
        </div>
    </div>
</div>


@endsection
