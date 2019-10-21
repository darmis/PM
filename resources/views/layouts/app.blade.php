<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="container-fluid p-0">
                <a class="navbar-brand logo-area" href="{{ url('/dashboard') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest
                        @else
                            @if (Cookie::get('start_time') !== null)
                                <a href="#" class="btn-clockin hidden"><i class="fas fa-stopwatch"></i></a>
                                <a href="#" class="red btn-clockout"><i class="fas fa-stopwatch"></i></a>
                            @else
                                <a href="#" class="btn-clockin"><i class="fas fa-stopwatch"></i></a>
                                <a href="#" class="red btn-clockout hidden"><i class="fas fa-stopwatch"></i></a>
                            @endif
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src="{{ asset('storage/'. Auth::user()->image) }}" width="30px" height="30px" class="rounded-circle"><span class="px-2">{{ Auth::user()->name }} </span><span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/user/{{ Auth::user()->id }}">
                                        {{ __('My profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            <div class="container-fluid">
                <div class="row">
                    @guest
                        <div class="col-md-12">
                    @else
                        <div class="left-nav col-lg-2 col-md-12 col-sm-12">
                            <div class="left-nav-user-area">
                                {{-- <img src="{{ asset('storage/'. Auth::user()->image) }}" class="rounded-circle"> --}}
                                <div class="name-text">{{ Auth::user()->name }} {{ Auth::user()->lastname }}</div>
                                <div class="role-text">{{ Auth::user()->title }}</div>
                            </div>
                            <div class="left-menu-item">
                                <a href="{{ url('/dashboard') }}" class="{{ Request::is('dashboard') ? 'now-on' : '' }}"><i class="fa fa-desktop"></i>{{ __('Dashboard') }}</a>
                            </div>
                            <div class="hr"></div>
                            <div class="left-menu-item">
                                <a href="{{ url('/project') }}" class="{{ Request::is('project') ? 'now-on' : '' }}"><i class="fa fa-project-diagram"></i>{{ __('Projects') }}</a>
                                <div class="left-menu-item-inner">
                                    <a href="{{ url('/task') }}" class="{{ Request::is('task') ? 'now-on' : '' }}"><i class="fa fa-thumbtack"></i>{{ __('Tasks') }}</a>
                                </div>
                            </div>
                            <div class="hr"></div>
                            <div class="left-menu-item">
                                <a href="{{ url('/timing') }}" class="{{ Request::is('timing') ? 'now-on' : '' }}"><i class="fa fa-stopwatch"></i>{{ __('Timings') }}</a>
                            </div>
                            {{-- <div class="left-menu-item">
                                <a href="{{ url('/paying') }}" class="{{ Request::is('paying') ? 'now-on' : '' }}"><i class="fa fa-tags"></i>{{ __('Payings') }}</a>
                            </div> --}}
                            <div class="left-menu-item">
                                <a href="{{ url('/invoice') }}" class="{{ Request::is('invoice') ? 'now-on' : '' }}"><i class="fa fa-file-invoice"></i>{{ __('Invoices') }}</a>
                            </div>
                            <div class="hr"></div>
                            <div class="left-menu-item">
                                <a href="{{ url('/calendar') }}" class="{{ Request::is('calendar') ? 'now-on' : '' }}"><i class="fa fa-calendar-alt"></i>{{ __('Calendar') }}</a>
                            </div>
                            <div class="hr"></div>
                            <div class="left-menu-item">
                                <a href="{{ url('/client') }}" class="{{ Request::is('client') ? 'now-on' : '' }}"><i class="fa fa-id-card"></i>{{ __('Clients') }}</a>
                            </div>
                            <div class="hr"></div>
                            <div class="left-menu-item">
                                <a href="{{ url('/user') }}" class="{{ Request::is('user') ? 'now-on' : '' }}"><i class="fa fa-users"></i>{{ __('Users') }}</a>
                            </div>
                            <div class="hr"></div>
                            <div class="left-menu-item">
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form-left').submit();"><i class="fa fa-sign-out-alt"></i>{{ __('Logout') }}</a>
                                <form id="logout-form-left" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-10 col-md-12 col-sm-12 px-0">
                    @endguest
                        @include('inc.messages')
                        @yield('content')
                </div>
            </div>
        </main>
@guest

@else
    @include('timings.timingModal')
    <script>

    document.addEventListener("DOMContentLoaded", function(event) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //clockin clockout
        $('.btn-clockin').on('click', clockIn);
        $('.btn-clockout').on('click', clockOut);

        function clockIn() {
            $('.btn-clockout').removeClass('hidden');
            $('.btn-clockin').addClass('hidden');
            $('.clockin-text-1').text('{{ __("You are clocked in") }}');
            $('.clockin-text-2').text('{{ __("since: ") }} {{ Carbon\Carbon::now()->format("H:i") }}');
            $.ajax({
                type: "get",
                url: "{{ route('addClockIn') }}"
            });
        }

        function clockOut() {
            $('#timingModal').modal('show');
            $('#timingModalSubmit').on('click',function(){
                $.ajax({
                    type: "get",
                    url: "{{ route('addClockOut') }}",
                    data: {
                        note: $('.note').val(),
                        taskID: $('#timingSelect').val()
                    }
                }).done(function( msg ) {
                    $('#timingModal').modal('hide');
                    $('.btn-clockin').removeClass('hidden');
                    $('.btn-clockout').addClass('hidden');
                    $('.clockin-text-1').text('{{ __("You are not") }}');
                    $('.clockin-text-2').text('{{ __("clocked in") }}');
                    $('.note').val('');
                });

            });



        }
    });

    </script>
@endguest
</body>
</html>
