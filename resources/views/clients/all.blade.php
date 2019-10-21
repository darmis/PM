@extends('layouts.app')

@section('content')
<div class="justify-content-center">
    <div class="card">
        <div class="card-header text-center text-uppercase">{{ __($name) }}</div>

        <div class="card-body">
            <h3>
                @if(Auth::user()->isAdmin)
                    <span class="float-left"><a href="/client/create" class="btn btn-success btn-sm">{{ __('Create a new client') }}</a></span>
                @endif
            </h3>
            @if(count($clients))
                <table class="table table-sm table-hover table-striped">
                    <tr>
                        <th>ID</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Address') }}</th>
                        <th>{{ __('Phone') }}</th>
                        <th>{{ __('E-mail') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    @foreach($clients as $client)
                    <tr>
                        <td><a href="{{ url('/client') }}/{{ $client->id }}">{{ $client->id }}</a></td>
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->address }}</td>
                        <td>{{ $client->phone }}</td>
                        <td>{{ $client->email }}</td>
                        <td>
                            <div class="row">
                                <span><a href="{{ url('/client') }}/{{ $client->id }}" class="btn btn-primary btn-sm"><i class="fa fa-search"></i></a></span>
                            @if(Auth::user()->isAdmin)
                                <span><a href="{{ url('/client') }}/{{ $client->id }}/edit" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a></span>
                                <span>
                                    <form method="POST" action="{{ url('/client') }}/{{ $client->id }}">
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
                {{$clients->links()}}
            @endif
        </div>
    </div>
</div>


@endsection
