@extends('layouts.app')

@section('content')
<div class="justify-content-center">
    <div class="card">
        <div class="card-header text-center text-uppercase">{{ __('Create a user') }}</div>

        <div class="card-body">
            <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <div class="col-md-4">
                        <label for="name" class="col-form-label text-md-right">{{ __('Name') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    </div>
                    <div class="col-md-4">
                        <label for="lastname" class="col-form-label text-md-right">{{ __('Last Name') }}</label>
                        <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>
                    </div>

                    <div class="col-md-4">
                        <label for="title" class="col-form-label text-md-right">{{ __('Title') }}</label>
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>
                    </div>
                </div>

                <div class="form-group row">
                        <div class="col-md-6">
                            <label for="address" class="col-form-label text-md-right">{{ __('Address') }}</label>
                            <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" autocomplete="address" autofocus>
                        </div>
                        <div class="col-md-3">
                            <label for="dob" class="col-form-label text-md-right">{{ __('D.O.B.') }}</label>
                            <input id="dob" type="text" class="form-control date @error('dob') is-invalid @enderror" name="dob" value="{{ old('dob') }}" autocomplete="dob" autofocus>
                        </div>
                        <div class="col-md-3">
                            <label for="gender" class="col-form-label text-md-right">{{ __('Gender') }}</label>
                                <div id="gender">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="maleRadio" value="male">
                                        <label class="form-check-label" for="maleRadio">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="femaleRadio" value="female">
                                        <label class="form-check-label" for="femaleRadio">Female</label>
                                    </div>
                                </div>
                        </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                        <label for="image" class="col-form-label text-md-right">{{ __('Image') }}</label>
                        <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" autocomplete="image">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-dark px-4">
                            {{ __('Register') }}
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
