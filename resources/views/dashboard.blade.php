@extends('layouts.app')

@section('content')
<link href='{{ asset('storage/packages/datepicker/datepicker.min.css') }}' rel='stylesheet' />
<script src='{{ asset('storage/packages/datepicker/datepicker.min.js') }}'></script>
<div class="row m-0">
    <div class="col-lg-3 col-md-6 my-2">
        <div class="dash-top">
            <div class="d-inline-block"><i class="fas fa-stopwatch"></i></div>
            <div class="dash-top-clockin-info d-inline-block float-right">
                @if (Cookie::get('start_time') !== null)
                    <span class="clockin-text-1">{{ __('You are clocked in') }}</span><br>
                <span class="clockin-text-2">{{ __('since: ') }}{{ Carbon\Carbon::parse(Cookie::get('start_time'))->format("H:i") }}</span>
                @else
                    <span class="clockin-text-1">{{ __('You are not') }}</span><br>
                    <span class="clockin-text-2">{{ __('clocked in') }}</span>
                @endif
            </div>
            <div class="dash-top-text text-center py-2">
                @if (Cookie::get('start_time') !== null)
                    <button class="btn btn-sm btn-clockin hidden px-4 color-b">{{ __('Clock In') }}</button>
                    <button class="btn btn-sm btn-clockout px-4 color-o red">{{ __('Clock Out') }}</button>
                @else
                    <button class="btn btn-sm btn-clockin px-4 color-b">{{ __('Clock In') }}</button>
                    <button class="btn btn-sm btn-clockout hidden px-4 color-o red">{{ __('Clock Out') }}</button>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 my-2">
        <div class="dash-top">
            <div class="d-inline-block"><i class="fa fa-project-diagram"></i></div>
            <div class="dash-top-info d-inline-block float-right">{{ !$myProjectsCount ? '-' : $myProjectsCount }}</div>
            <div class="dash-top-text text-center py-2">
                <a href="/myProjects">{{ __('My projects') }}</a>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 my-2">
        <div class="dash-top">
            <div class="d-inline-block"><i class="fa fa-thumbtack"></i></div>
            <div class="dash-top-info d-inline-block float-right">{{ !$myOpenTasksCount ? '-' : $myOpenTasksCount }}</div>
            <div class="dash-top-text text-center py-2">
                <a href="/myOpenTasks">{{ __('My open tasks') }}</a>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 my-2">
        <div class="dash-top-last">
            <div id="date-time"></div>
            <div class="hr"></div>
            <div class="container text-center">
                <div class="d-inline text-center dash-top-icon px-4">
                    @if (Cookie::get('start_time') !== null)
                        <a href="#" class="btn-clockin hidden"><i class="fas fa-stopwatch"></i></a>
                        <a href="#" class="red btn-clockout"><i class="fas fa-stopwatch"></i></a>
                    @else
                        <a href="#" class="btn-clockin"><i class="fas fa-stopwatch"></i></a>
                        <a href="#" class="red btn-clockout hidden"><i class="fas fa-stopwatch"></i></a>
                    @endif
                </div>
                <div class="dash-top-vr"></div>
                <div class="d-inline text-center dash-top-icon px-4"><a href="{{ url('/task') }}"><i class="fa fa-thumbtack"></i></a></div>
                <div class="dash-top-vr"></div>
                <div class="d-inline text-center dash-top-icon px-4"><a href="{{ url('/calendar') }}"><i class="fa fa-calendar-alt"></i></a></div>
            </div>
        </div>
    </div>
</div>
<div class="row m-0 py-2">
    <div class="col-lg-4">
        <div class="summary-panel">
            <div class="panel-header">
                <i class="fa fa-stream"></i>
                <span>{{ __('Totals') }}</span>
            </div>
            <div class="summary">
                <div class="d-inline-block border-right p-2">
                    <div class="summary-info">{{ !$totalProjectsCount ? '-' : $totalProjectsCount }}</div>
                    <div class="summary-text">{{ __('Projects') }}</div>
                </div>
                <div class="d-inline-block border-right p-2">
                    <div class="summary-info">{{ !$totalTasksCount ? '-' : $totalTasksCount }}</div>
                    <div class="summary-text">{{ __('Tasks') }}</div>
                </div>
                <div class="d-inline-block p-2">
                    <div class="summary-info">{{ !$totalTimingsCount ? '-' : $totalTimingsCount }}</div>
                    <div class="summary-text">{{ __('Timings') }}</div>
                </div>
            </div>
            <div class="summary border-top">
                <div class="d-inline-block border-right p-2">
                    <div class="summary-info">{{ !$totalClientsCount ? '-' : $totalClientsCount }}</div>
                    <div class="summary-text">{{ __('Clients') }}</div>
                </div>
                <div class="d-inline-block border-right p-2">
                    <div class="summary-info">{{ !$totalInvoicesCount ? '-' : $totalInvoicesCount }}</div>
                    <div class="summary-text">{{ __('Invoices') }}</div>
                </div>
                <div class="d-inline-block p-2">
                    <div class="summary-info">{{ !$totalTimings ? '-' : $totalTimings }}</div>
                    <div class="summary-text">{{ __('Worked (h)') }}</div>
                </div>
            </div>
        </div>
        <div class="chart-panel">
            <div class="panel-header">
                <i class="far fa-chart-bar"></i>
                <span>{{ __('Chart') }}</span>
            </div>
            <div class="chart-panel-body">
                {!! $chart->renderHtml() !!}
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="tasks-timeline-panel">
            <div class="panel-header">
                <i class="fa fa-thumbtack"></i>
                <span>{{ __('Tasks timeline') }}</span>
            </div>
            <div class="tasks-timeline-panel-body p-1">
                <div class="timeline-list">

                </div>
                <div class="spinner text-center">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="calendar-panel">
            <div class="panel-header">
                <i class="fa fa-calendar-alt"></i>
                <span>{{ __('Today') }}</span>
            </div>
            <div class="calendar-area">
                @if(count($todayCalendars))
                    @foreach($todayCalendars as $event)
                        <div class="event-item">
                            <div title="{{ $event->description }}">{{ $event->name }}</div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center"><i class="far fa-calendar-times"></i></div>
                @endif
                <div class="text-center">
                    <a href="/calendar" class="badge badge-light">{{ __('View All') }}</a>
                    <a href="#" class="badge badge-dark" data-toggle="modal" data-target="#calendarCreateModal">{{ __('Create') }}</a>
                </div>
            </div>
        </div>
        <div class="todo-panel">
            <div class="panel-header">
                <i class="fa fa-list-alt"></i>
                <span>{{ __('Todo') }}</span>
            </div>
            <div class="todo-area">
                <form action="/todo" method="POST">
                    @csrf
                    <input type="text" name="todo" placeholder="Enter todo" class="todo-input">
                    <button type="submit" class="btn btn-sm btn-secondary">></button>
                </form>
                <div class="todos-container">
                    @foreach($todos as $todo)
                        <div class="todo">
                            <div class="d-inline badge badge-secondary">
                                {{ $todo->todo }}
                                <form action="/todo/{{ $todo->id }}" method="POST" class="todo-form d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-small"><i class="far fa-trash-alt"></i></button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="notes-panel">
            <div class="panel-header">
                <i class="far fa-clipboard"></i>
                <span>{{ __('Notes') }}</span>
            </div>
            <div class="note-area">
                <textarea class="dashboard-note">{!! $note->note !!}</textarea>
            </div>
        </div>
    </div>
</div>

@include('calendar.create')

<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //dashboard note stuff
        $('.dashboard-note').on('input', function() {
            var text = $('.dashboard-note').val();

            $.ajax({
                type: "get",
                url: "{{ url('/trackNote') }}",
                data: { content: text }
            });
        });
        //load date-time
        dateTime();
        //tasks timeline loading stuff
        var page = 1;
        var lastPage = 999999;
        loadMoreData(page);

        $('.tasks-timeline-panel-body').scroll(function() {
            if($('.tasks-timeline-panel-body').scrollTop() + $('.tasks-timeline-panel-body').height() >= $('.tasks-timeline-panel-body').height()) {
                page++;
                if(lastPage >= page){
                loadMoreData(page);
            }
        }

        $('.todo-input').on('keypress',function(e) {
            if(e.which == 13) {
                e.preventDefault();
                $('.todo-form').submit();
            }
        });
    });


    //tasks timeline
    function loadMoreData(page){
        $.ajax({
                url: 'http://pm.local/loadingTasks?page=' + page,
                type: "get",
                beforeSend: function()
                {
                    $('.spinner').show();
                }
        })
        .done(function(data){
            $('.spinner').hide();
            $.each(data.data, function(x) {
                $(".timeline-list").append('<div class="timeline-item p-2 border-bottom">'+
                    '<div class="timeline-line"><span class="timeline-info-text font-weight-bold">Updated at:</span><span class="badge badge-secondary">'
                        +'</div><div class="timeline-line"><span class="badge badge-secondary">'+
                        data.data[x].updated_at +'</span><span class="timeline-info float-right badge badge-secondary">'+ data.data[x].status +'</span></div>'+
                    '<div class="py-2 text-center"><a class="timeline-link" href="/task/'+ data.data[x].id +'">'+ data.data[x].name +'</a></div>');
            });
            lastPage = data.last_page;
        })
        .fail(function(jqXHR, ajaxOptions, thrownError){
            console.log('server not responding...');
        });
    }

    //date-time function call
    setInterval(dateTime,1000);

    function dateTime(){
        var str = "";
        var days = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
        var months = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

        var now = new Date();

        if(now.getMinutes() < 10){
            var minutes = '0' + now.getMinutes();
        } else {
            var minutes = now.getMinutes();
        }

        str += "<div class='time text-center'>" + now.getHours() +":" + minutes + "</div><div class='text-center'><div class='d-inline day'>"
        + days[now.getDay()] + ",<div class='d-inline px-2 date'>" + now.getDate() + " " + months[now.getMonth()]
        + " " + now.getFullYear() + "</div></div></div>";

        document.getElementById("date-time").innerHTML = str;
    }



});

</script>

{!! $chart->renderChartJsLibrary() !!}
{!! $chart->renderJs() !!}
@endsection
