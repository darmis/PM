@extends('layouts.app')

@section('content')
<div class="justify-content-center">
    <div class="card">
        <div class="card-header text-center text-uppercase">{{ __('Edit client information') }}</div>

        <div class="card-body">
            @include('inc.messages')
            <form method="POST" action="{{ url('/client') }}/{{ $client->id }}">
                @csrf
                @method('PUT')
                <div class="col-md-8 offset-md-2">
                    <label for="name" class="col-form-label text-md-right">{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $client->name }}" required autocomplete="name" autofocus>

                    <label for="address" class="col-form-label text-md-right">{{ __('Address') }}</label>
                    <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $client->address }}" required autocomplete="address" autofocus>

                    <label for="phone" class="col-form-label text-md-right">{{ __('Phone') }}</label>
                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $client->phone }}" required autocomplete="phone" autofocus>

                    <label for="email" class="col-form-label text-md-right">{{ __('E-mail') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $client->email }}" required autocomplete="email" autofocus>

                    <label for="description" class="col-form-label text-md-right">{{ __('Description') }}</label>
                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="5">{{ $client->description }}</textarea>

                    <div class="col-md-12 text-center py-2">
                        <button type="submit" class="btn btn-dark px-4">
                            {{ __('Save') }}
                        </button>
                    </div>

                </div>

            </form>
        </div>
    </div>
</div>
@endsection
