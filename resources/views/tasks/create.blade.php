@extends('layouts.app')

@section('content')
<div class="justify-content-center">
    <div class="card">
        <div class="card-header text-center text-uppercase">{{ __('Create a new task') }}</div>

        <div class="card-body">
            <form method="POST" action="{{ route('task.store') }}">
                @csrf
                <div class="col-md-8 offset-md-2">
                    <label for="name" class="col-form-label text-md-right">{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                    <label for="description" class="col-form-label text-md-right">{{ __('Description') }}</label>
                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="5">{{ old('description') }}</textarea>

                    <div class="row">
                        <div class="col-md-4">
                            <label for=startdatee" class="col-form-label text-md-right">{{ __('Start date') }}</label><br>
                            <input id="startdate" type="text" class="form-control date @error('startdate') is-invalid @enderror" name="startdate" value="{{ old('startdate') }}" required autocomplete="startdate" autofocus>
                        </div>
                        <div class="col-md-4">
                            <label for="deadline" class="col-form-label text-md-right">{{ __('Deadline') }}</label><br>
                            <input id="deadline" type="deadline" class="form-control date @error('deadline') is-invalid @enderror" name="deadline" value="{{ old('deadline') }}" required autocomplete="deadline" autofocus>
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="col-form-label text-md-right">{{ __('Status') }}</label>
                            <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="Not started yet">{{ __('Not started yet') }}</option>
                                <option value="In progress">{{ __('In progress') }}</option>
                                <option value="Done">{{ __('Done') }}</option>
                            </select>
                        </div>
                    </div>

                    <label for="project" class="col-form-label text-md-right">{{ __('Project') }}</label>
                    <select id="project" name="project_id" class="form-control @error('project') is-invalid @enderror">
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>

                    <label for="members" class="col-form-label text-md-right">{{ __('Team members') }}</label>
                    <select id="members" name="members[]" class="form-control @error('members') is-invalid @enderror" multiple>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} {{ $user->lastname }}</option>
                        @endforeach
                    </select>


                    <div class="col-md-12 text-center py-2">
                        <button type="submit" class="btn btn-dark px-4">
                            {{ __('Create') }}
                        </button>
                    </div>

                </div>

            </form>
        </div>
    </div>
</div>
<link href='{{ asset('storage/packages/datepicker/datepicker.min.css') }}' rel='stylesheet' />
<script src='{{ asset('storage/packages/datepicker/datepicker.min.js') }}'></script>
<script>
    datepickr('.date', { dateFormat: 'Y-m-d'});
</script>
@endsection
