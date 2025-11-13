@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
@push('styles')
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('library/fullcalendar/dist/fullcalendar.min.css') }}">
@endpush

{{-- 🔔 Modal DITARUH DI LUAR main-content --}}
@if (count($notifROP) > 0)
    <div class="modal fade" id="notifModal" tabindex="-1" aria-labelledby="notifModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-warning shadow-lg">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title font-weight-bold" id="notifModalLabel">⚠️ Stok Menipis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul>
                        @foreach ($notifROP as $item)
                            <li class="mb-1">
                                Barang : <strong>{{ $item['nama_barang'] }}</strong> stok 
                                <strong>{{ $item['stok'] }}</strong> 
                                {{-- ( <strong>{{ $item['rop'] }}</strong>) --}}
                            </li>
                        @endforeach
                    </ul>
                    <p class="text-danger font-weight-bold mb-0">
                        Segera lakukan pemesanan ulang untuk barang di atas!
                    </p>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('admin.riwayat') }}" class="btn btn-warning">
                        <i class="fas fa-boxes"></i> Pesan Barang
                    </a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>
                @if (Auth::user()->role === 'admin')
                    Admin
                @endif
                Dashboard
            </h1>
        </div>

        {{-- Statistik Utama --}}
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-cubes"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header"><h4>Total Rak</h4></div>
                        <div class="card-body">{{ $data['totalrak'] }}</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header"><h4>Total Barang</h4></div>
                        <div class="card-body">{{ $data['totalbarang'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Activities --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header"><h4>Recent Activities</h4></div>
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
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Menambahkan data barang baru</td>
                                        <td>2025-11-13</td>
                                        <td>Admin</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Calendar --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header"><h4>Calendar of Events</h4></div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
    {{-- ❌ JANGAN ulangi jQuery/bootstrap di sini --}}
    <script src="{{ asset('library/fullcalendar/dist/fullcalendar.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/id.min.js"></script>

    <style>
        .modal-backdrop { z-index: 1040 !important; }
        .modal { z-index: 1050 !important; }
    </style>

    {{-- ✅ Modal otomatis tampil --}}
    @if (count($notifROP) > 0)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(() => $('#notifModal').modal('show'), 500);
        });
    </script>
    @endif
@endpush
@endsection
