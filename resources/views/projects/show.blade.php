@extends('layouts.app')

@section('content')
    <div class="color-o row m-0">
        <div class="col-md-3 text-center">
            <div class="text-b font-weight-bold py-2">{{ $project->name }}</div>
            <div class="py-2">Start date: {{ $project->startdate }} <br> Deadline: {{ $project->deadline }}</div>
        </div>
        <div class="col-md-3 py-3">
            <div class="py-1"><span class="text-b font-weight-bold">Client:</span> <a href="{{ url('client') }}/{{ $project->client->id }}" class="badge badge-dark px-2">{{ $project->client->name }}</a></div>
            <div class=""><span class="text-b font-weight-bold">Creator</span>: <a href="{{ url('user') }}/{{ $creator->id }}" class="badge badge-dark px-2">{{ $creator->name }} {{ $creator->lastname }}</a></div>
            <div class="py-1"><span class="text-b font-weight-bold">Status:</span> {{ $project->status }}</div>

        </div>
        <div class="col-md-3 py-3">
            <div class="text-b font-weight-bold py-1">Team members:</div>
            @foreach($members as $member)
                <a href="{{ url('user') }}/{{ $member->id }}" class="badge badge-dark px-2">{{ $member->name }} {{ $member->lastname }}</a>
            @endforeach
        </div>
    </div>
    <div class="row m-0">
        <div class="text-b font-weight-bold">Description:</div>
        <textarea class="col-md-12" name="description" id="description" cols="30" rows="10">{{ $project->description }}</textarea>
    </div>

@endsection
