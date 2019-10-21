@extends('layouts.app')

@section('content')
    <div class="color-o row m-0">
        <div class="col-md-3 text-center">
            <div class="text-b font-weight-bold py-2">{{ $client->name }}</div>
            <div class="py-2">{{ $client->address }}</div>
            <div class="py-2">{{ $client->phone }}</div>
            <div class="py-2"><a href="mailto:{{ $client->email }}" class="badge badge-dark px-2"><i class="fa fa-paper-plane p-1"></i>{{ $client->email }}</a></div>
        </div>
        <div class="col-md-3 py-3">

        </div>
        <div class="col-md-6">

        </div>
    </div>
    <div class="row m-0">
        <div class="text-b font-weight-bold">Description:</div>
        <textarea class="col-md-12" name="description" id="description" cols="30" rows="10">{{ $client->description }}</textarea>
    </div>

@endsection
