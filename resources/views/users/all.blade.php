@extends('layouts.app')

@section('content')
<div class="justify-content-center">
    <div class="card">
        <div class="card-header text-center text-uppercase">{{ __($name) }}</div>

        <div class="card-body">
            <h3>
                @if(Auth::user()->isAdmin)
                    <span class="float-left"><a href="/user/create" class="btn btn-success btn-sm">{{ __('Create a new user') }}</a></span>
                @endif
            </h3>
            @if(count($users))
                <table class="table table-sm table-hover table-striped">
                    <tr>
                        <th>ID</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Last Name') }}</th>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('E-mail') }}</th>
                        <th>{{ __('Role') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    @foreach($users as $user)
                    <tr>
                        <td><a href="{{ url('/user') }}/{{ $user->id }}">{{ $user->id }}</a></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->lastname }}</td>
                        <td>{{ $user->title }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->isAdmin ? 'Admin' : 'User' }}</td>
                        <td>
                            <div class="row">
                                <span><a href="{{ url('/user') }}/{{ $user->id }}" class="btn btn-primary btn-sm"><i class="fa fa-search"></i></a></span>
                            @if(Auth::user()->isAdmin)
                                <span><a href="{{ url('/user') }}/{{ $user->id }}/edit" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a></span>
                                <span>
                                    <form method="POST" action="{{ url('/user') }}/{{ $user->id }}">
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
                {{$users->links()}}
            @endif
        </div>
    </div>
</div>


@endsection
