@extends('layouts.app')

@section('content')
<div class="justify-content-center">
        <div class="card">
            <div class="card-header text-center text-uppercase">{{$name}}</div>

            <div class="card-body">
                @include('calendar.calendar')
            </div>
        </div>
    </div>
@endsection
