@extends('layouts.app')

@section('content')
<div class="justify-content-center">
    <div class="card">
        <div class="card-header text-center text-uppercase">{{ __('Update timing') }}</div>

        <div class="card-body">
            <form method="POST" action="{{ url('/timing') }}/{{ $timing->id }}">
                @csrf
                @method('PUT')
                <div class="col-md-8 offset-md-2">
                    <label for="note" class="col-form-label text-md-right">{{ __('Note') }}</label>
                    <textarea id="note" class="form-control @error('note') is-invalid @enderror" name="note" rows="5">{{ $timing->note }}</textarea>

                    <label for="task" class="col-form-label text-md-right">{{ __('Select task') }}</label>
                    <select id="task" name="task_id" class="form-control @error('task') is-invalid @enderror">
                        @foreach($tasks as $task)
                            <option value="{{ $task->id }}" {{ $timing->task_id == $task->id ? 'selected' : '' }}>{{ $task->name }}</option>
                        @endforeach
                    </select>

                    <div class="col-md-12 text-center py-2">
                        <button type="submit" class="btn btn-dark px-4">
                            {{ __('Update timing') }}
                        </button>
                    </div>

                </div>

            </form>
        </div>
    </div>
</div>
@endsection
