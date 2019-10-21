@extends('layouts.app')

@section('content')
    <div class="color-o row m-0">
        <div class="col-md-3 text-center">
            <img src="{{ asset('storage/'. $user->image) }}" width="200px" height="200px" class="rounded-circle p-3">
            <div class="text-b font-weight-bold py-2">{{ $user->name }} {{ $user->lastname }}</div>
        </div>
        <div class="col-md-3 py-3">
            <div class="m-2 my-4">
                <div class="m-2">
                    <a href="#" class="badge badge-secondary"></a><i class="fa fa-user-tag px-2 py-1"></i>{{ $user->title }}
                </div>
                <div class="py-3"></div>
                <div class="m-2">
                    <a href="mailto:{{ $user->email }}" class="badge badge-dark px-2"><i class="fa fa-paper-plane p-1"></i>{{ $user->email }}</a>
                </div>
                <div class="m-2">
                    <button class="btn btn-sm btn-outline-dark px-2"><i class="fa fa-at p-1"></i>me</button>
                </div>
            </div>
        </div>
    </div>

@endsection
