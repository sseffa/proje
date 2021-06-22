@extends('layout._layout')

@section('content')

    <link rel="stylesheet" media="screen, print" href="/assets/css/miscellaneous/fullcalendar/fullcalendar.bundle.css">
    <main id="js-page-content" role="main" class="page-content">
    <!--<ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item">Bilgilendirme</li>
            <li class="breadcrumb-item active">{{ auth()->user()->name }}</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-chart-area'></i> İstatistikler <span class='fw-300'></span>
            </h1>
        </div>
        -->
        <!--
        <div class="row">
            <div class="col-sm-6 col-xl-3">
                <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">

                            <small class="m-0 l-h-n">Ekip</small>
                        </h3>
                    </div>
                    <i class="fal fa-users position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1"
                       style="font-size:6rem"></i>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">

                            <small class="m-0 l-h-n">Üye</small>
                        </h3>
                    </div>
                    <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4"
                       style="font-size: 6rem;"></i>
                </div>
            </div>
        </div>
        -->

        <div id="panel-3" class="panel col-12">
            <div class="panel-hdr">
                <h2 class="js-get-date"></h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </main>
    <script src="/assets/js/dependency/moment/moment.js"></script>
    <script src="/assets/js/dependency/moment/locale/tr.js"></script>
    <script src="/assets/js/miscellaneous/fullcalendar/fullcalendar.bundle.js"></script>
    <script>
        var todayDate = moment().startOf('day');
        moment.locale('tr');
        var YM = todayDate.format('YYYY-MM');
        var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
        var TODAY = todayDate.format('YYYY-MM-DD');
        var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');


        document.addEventListener('DOMContentLoaded', async function()
        {
            async function getMeetings() {
                let url = '/getMeetings';
                try {
                    let res = await fetch(url);
                    return await res.json();
                } catch (error) {
                    console.log(error);
                }
            }

            let meetings = await getMeetings();
            let data = [];

            meetings.forEach(meet => {
                let obj =  {
                    title: meet.content + " (" + meet.team.name + ") ",
                    start: meet.meet_date,
                    description: meet.team.name + " " + meet.content,
                    className: "border-warning bg-warning text-dark"
                };

                data.push(obj);
            });

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl,
                {
                    plugins: ['dayGrid', 'list', 'timeGrid', 'interaction', 'bootstrap'],
                    themeSystem: 'bootstrap',
                    timeZone: 'UTC',
                    locale: 'tr',
                    //dateAlignment: "month", //week, month
                    buttonText:
                        {
                            today: 'Bugün',
                            month: 'Aylık',
                            week: 'Haftalık',
                            day: 'Günlük',
                            list: 'Liste'
                        },
                    eventTimeFormat:
                        {
                            hour: 'numeric',
                            minute: '2-digit',
                            meridiem: 'short'
                        },
                    navLinks: true,
                    header:
                        {
                            left: 'prev,next today addEventButton',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                        },
                    footer:
                        {
                            left: '',
                            center: '',
                            right: ''
                        },
                    customButtons:
                        {
                            /*
                            addEventButton:
                                {
                                    text: '+',
                                    click: function()
                                    {
                                        var dateStr = prompt('Enter a date in YYYY-MM-DD format');
                                        var date = new Date(dateStr + 'T00:00:00'); // will be in local time

                                        if (!isNaN(date.valueOf()))
                                        { // valid?
                                            calendar.addEvent(
                                                {
                                                    title: 'dynamic event',
                                                    start: date,
                                                    allDay: true
                                                });
                                            alert('Great. Now, update your database...');
                                        }
                                        else
                                        {
                                            alert('Invalid date.');
                                        }
                                    }
                                }
                                */
                        },
                    //height: 700,
                    editable: true,
                    eventLimit: true, // allow "more" link when too many events
                    views:
                        {
                            sevenDays:
                                {
                                    type: 'agenda',
                                    buttonText: '7 Günlük',
                                    visibleRange: function(currentDate)
                                    {
                                        return {
                                            start: currentDate.clone().subtract(2, 'days'),
                                            end: currentDate.clone().add(5, 'days'),
                                        };
                                    },
                                    duration:
                                        {
                                            days: 7
                                        },
                                    dateIncrement:
                                        {
                                            days: 1
                                        },
                                },
                        },
                    events: data,
                    /*eventClick:  function(info) {
                    	$('#calendarModal .modal-title .js-event-title').text(info.event.title);
                    	$('#calendarModal .js-event-description').text(info.event.description);
                    	$('#calendarModal .js-event-url').attr('href',info.event.url);
                    	$('#calendarModal').modal();
                    	console.log(info.event.className);
                    	console.log(info.event.title);
                    	console.log(info.event.description);
                    	console.log(info.event.url);
                    },*/
                    /*viewRender: function(view) {
                    	localStorage.setItem('calendarDefaultView',view.name);
                    	$('.fc-toolbar .btn-primary').removeClass('btn-primary').addClass('btn-outline-secondary');
                    },*/

                });

            calendar.render();
        });

    </script>
@stop
