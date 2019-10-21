
<link href='{{ asset('storage/packages/fullCalendar/core/main.css') }}' rel='stylesheet' />
<link href='{{ asset('storage/packages/fullCalendar/daygrid/main.css') }}' rel='stylesheet' />
<link href='{{ asset('storage/packages/fullCalendar/timegrid/main.css') }}' rel='stylesheet' />
<link href='{{ asset('storage/packages/fullCalendar/list/main.css') }}' rel='stylesheet' />
<link href='{{ asset('storage/packages/datepicker/datepicker.min.css') }}' rel='stylesheet' />
<script src='{{ asset('storage/packages/fullCalendar/core/main.js') }}'></script>
<script src='{{ asset('storage/packages/fullCalendar/core/locales-all.js') }}'></script>
<script src='{{ asset('storage/packages/fullCalendar/interaction/main.js') }}'></script>
<script src='{{ asset('storage/packages/fullCalendar/daygrid/main.js') }}'></script>
<script src='{{ asset('storage/packages/fullCalendar/timegrid/main.js') }}'></script>
<script src='{{ asset('storage/packages/fullCalendar/list/main.js') }}'></script>
<script src='{{ asset('storage/packages/datepicker/datepicker.min.js') }}'></script>
<script src='{{ asset('storage/packages/moment.js') }}'></script>

@include('calendar.create')
@include('calendar.edit')
<div id='calendar'></div>


<script>
    moment().format();
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            locale: '{{ str_replace('_', '-', app()->getLocale()) }}',
            timeZone: 'local',
            buttonIcons: false, // show the prev/next text
            weekNumbers: false,
            fixedWeekCount: false,
            aspectRatio: 2,
            navLinks: true, // can click day/week names to navigate views
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: [
                @if(!empty($calendars))
                    @foreach($calendars as $calendar)
                    {
                    id: '{{ $calendar->id }}',
                    title: '{{ $calendar->name }}',
                    description: '{{ $calendar->description }}',
                    start: '{{ $calendar->date }}'
                    },
                    @endforeach
                @endif
            ],
            eventDrop: function(eventDropInfo) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('/calendar/updateDate') }}",
                    type: "post",
                    data: {
                        id : eventDropInfo.event.id,
                        date: moment(eventDropInfo.event.start).format('YYYY-MM-DD')
                    }
                });
            },
            dateClick: function(info) {
                $('input[name="date"]').val(info.dateStr);
                $('#calendarCreateModal').modal('show');
            },
            eventClick: function(info) {
                $('input[name="id"]').val(info.event.id);
                $('input[name="editName"]').val(info.event.title);
                $('textarea[name="editDescription"]').val(info.event.extendedProps.description);
                $('input[name="editDate"]').val(moment(info.event.start).format('YYYY-MM-DD'));
                $('#calendarEditModal').modal('show');
            },
            // eventRender: function(info) {
            //     info.el.setAttribute('name', info.event.extendedProps.description);
            // }
        });

    calendar.render();
});
</script>
