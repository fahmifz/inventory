@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
@endpush

{{-- ================= MODAL NOTIFIKASI ROP ================= --}}
{{-- @if (count($notifROP) > 0)
<div class="modal fade" id="notifModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-danger shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle"></i> Notifikasi Reorder Point
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered">
                    <thead class="bg-light">
                        <tr class="text-center">
                            <th>Barang</th>
                            <th>Stok</th>
                            <th>ROP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notifROP as $item)
                        <tr class="text-center">
                            <td>{{ $item['nama_barang'] }}</td>
                            <td class="text-danger font-weight-bold">{{ $item['stok'] }}</td>
                            <td>{{ $item['rop'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <p class="text-danger font-weight-bold mb-0">
                    Segera lakukan restock sebelum stok habis.
                </p>
            </div>

            <div class="modal-footer">
                <a href="{{ route('admin.barang') }}" class="btn btn-danger">
                    <i class="fas fa-box"></i> Kelola Barang
                </a>
                <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif --}}
{{-- ================= END MODAL ================= --}}

{{-- ================= MODAL NOTIFIKASI ROP ================= --}}
@if (count($notifROP) > 0)

<div class="modal fade" id="notifModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-danger shadow">

```
        <div class="modal-header bg-danger text-white">
            <h5 class="modal-title">
                <i class="fas fa-exclamation-triangle"></i>
                Notifikasi Reorder Point (ROP)
            </h5>
            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">

            {{-- TOTAL RESTOK --}}
            <p class="mb-3 text-danger font-weight-bold">
                Tambahkan {{ $totalRestok }} barang sekarang!
            </p>

            <p class="mb-2">
                Barang berikut telah mencapai <strong>Reorder Point (ROP)</strong>
                dan perlu dilakukan pemesanan ulang:
            </p>

            <table class="table table-bordered table-hover">
                <thead class="bg-light text-center">
                    <tr>
                        <th>Prioritas</th>
                        <th>Nama Barang</th>
                        <th>Stok</th>
                        <th>ROP</th>
                        <th>Tambah</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($notifROP as $item)
                    <tr class="text-center">

                        <td>
                            <span class="badge badge-danger">
                                #{{ $item['rank'] }}
                            </span>
                        </td>

                        <td>
                            <strong>{{ $item['nama_barang'] }}</strong>
                            <br>
                            <small class="text-danger font-weight-bold">
                                Tambahkan {{ $item['tambah'] }} barang
                            </small>
                        </td>

                        <td class="text-danger font-weight-bold">
                            {{ $item['stok'] }}
                        </td>

                        <td>{{ $item['rop'] }}</td>

                        <td class="font-weight-bold text-danger">
                            +{{ $item['tambah'] }}
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="alert alert-warning mt-3 mb-0">
                Segera lakukan <strong>pemesanan ulang</strong> untuk mencegah kehabisan stok.
            </div>

        </div>

        <div class="modal-footer">
            <a href="{{ route('admin.riwayat') }}" class="btn btn-danger">
                <i class="fas fa-truck-loading"></i> Proses Pemesanan
            </a>
            <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>

    </div>
</div>
```

</div>
@endif

{{-- ================= END MODAL ================= --}}


<div class="main-content">
<section class="section">

{{-- ================= HEADER ================= --}}
<div class="section-header">
    <h1>Admin Dashboard</h1>
</div>

{{-- ================= STATISTIK ================= --}}
<div class="row">
    <div class="col-lg-3 col-md-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="fas fa-warehouse"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header"><h4>Total Rak</h4></div>
                <div class="card-body">{{ $data['totalrak'] }}</div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-success">
                <i class="fas fa-boxes"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header"><h4>Total Barang</h4></div>
                <div class="card-body">{{ $data['totalbarang'] }}</div>
            </div>
        </div>
    </div>
</div>

{{-- ================= DIAGRAM GARIS ================= --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Diagram Perbandingan Stok dan Reorder Point (ROP)</h4>
            </div>
            <div class="card-body">
                <canvas id="stokRopChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- ================= RECENT ACTIVITIES ================= --}}
{{-- <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header"><h4>Recent Activities</h4></div>
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Aktivitas</th>
                            <th>Tanggal</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Menambahkan data barang</td>
                            <td>{{ now()->format('d-m-Y') }}</td>
                            <td>Admin</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> --}}

{{-- ================= CALENDAR ================= --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header"><h4>Calendar</h4></div>
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>

</section>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/id.min.js"></script>

{{-- ================= CHART SCRIPT ================= --}}
<script>
const ctx = document.getElementById('stokRopChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($chartBarang),
        datasets: [
            {
                label: 'Stok',
                data: @json($chartStok),
                borderWidth: 2,
                tension: 0.4
            },
            {
                label: 'ROP',
                data: @json($chartRop),
                borderDash: [5,5],
                borderWidth: 2,
                tension: 0.4
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

{{-- ================= MODAL AUTO SHOW ================= --}}
@if (count($notifROP) > 0)
<script>
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => $('#notifModal').modal('show'), 500);
});
</script>
@endif

<script>
$(document).ready(function () {
    $('#calendar').fullCalendar({
        locale: 'id',
        height: 300
    });
});
</script>
@endpush
