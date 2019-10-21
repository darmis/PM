@extends('layouts.app')

@section('content')
    <div class="color-o row m-0">
        <div class="col-md-3 text-center">
            <div class="text-b font-weight-bold py-2">{{ $timing->user->name }} {{ $timing->user->lastname }}</div>
            <div class="py-2">
                Start time: {{ $timing->start_time }} <br>
                End time: {{ $timing->end_time }} <br>
                Time spent: <span class="font-weight-bold">{{ $timing->timespent }}</span></div>
        </div>
        <div class="col-md-9 py-3">
            <div class="py-1"><span class="text-b font-weight-bold">Client:</span> <a href="{{ url('client') }}/{{ $timing->task->project->client->id }}" class="badge badge-dark px-2">{{ $timing->task->project->client->name }}</a></div>
            <div class=""><span class="text-b font-weight-bold">Project:</span> <a href="{{ url('project') }}/{{ $timing->task->project->id }}" class="badge badge-dark px-2">{{ $timing->task->project->name }}</a></div>
            <div class="py-1"><span class="text-b font-weight-bold">Task:</span> <a href="{{ url('task') }}/{{ $timing->task->id }}" class="badge badge-dark px-2">{{ $timing->task->name }}</a></div>
        </div>
    </div>
    <div class="row m-0">
        <div class="text-b font-weight-bold">Note:</div>
        <textarea class="col-md-12" name="note" id="note" cols="30" rows="5">{{ $timing->note }}</textarea>
    </div>

@endsection
