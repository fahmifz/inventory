@extends('layouts.app', ['title' => 'Admin Dashboard'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/weathericons/css/weather-icons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/weathericons/css/weather-icons-wind.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
        <link rel="stylesheet" href="{{ asset('library/fullcalendar/dist/fullcalendar.min.css') }}">
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Admin Dashboard</h1>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Rak</h4>
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['totalrak'] }}</div>
                            <div class="card-body">
                               
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 style="white-space: nowrap;">Total Barang</h4>
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['totalbarang'] }}</div>
                            <div class="card-body">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Recent Activities</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Activity</th>
                                            <th>Date</th>
                                            <th>User</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Calendar of Events</h4>
                        </div>
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>

    @push('scripts')
        <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
        <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
        <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
        <script src="{{ asset('library/fullcalendar/dist/fullcalendar.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/id.min.js"></script>
        {{-- <script>
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: {!! json_encode($events) !!},
                    eventClick: function (info) {
                        alert('Event: ' + info.event.title + '\n' +
                            'Start: ' + info.event.start.toLocaleString());
                    }
                });
                calendar.render();
            });
        </script> --}}
    @endpush
@endsection