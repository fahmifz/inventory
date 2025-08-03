@extends('layouts.app', ['title' => 'Histori Transaksi'])

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</style>
@endpush

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Laporan penjualan</h1>
        </div>

        <div class="section-body">
            @if (Auth::user()->role === 'staff')
            <a href="{{ route('transaksi') }}" class="btn btn-primary mb-3">TAMBAH TRANSAKSI</a>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="table-rak">
                            <thead class="text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Total</th>
                                    @if (Auth::user()->role === 'admin')
                                    <th>Detail</th>
                                    <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksi as $index => $t)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">{{ $t->tanggal_transaksi }}</td>
                                    <td class="text-center">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                                    @if (Auth::user()->role === 'admin')
                                    <td class="text-center">
                                        <button type="button" class="btn btn-info btn-sm btn-detail" data-id="{{ $t->id }}">
                                            Detail
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('delete.transaksi', $t->id) }}" method="POST" class="form-hapus" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MODAL DETAIL -->
    <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="detailTableBody">
                            <tr class="text-center"><td colspan="4" class="text-center">Memuat...</td></tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-right">Total Keseluruhan:</th>
                                <th id="totalKeseluruhanDetail" class="text-success text-right">Rp 0</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- END MODAL -->
</div>

@push('scripts')
<script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('library/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>

@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: "{{ session('success') }}",
        confirmButtonColor: '#48c2f6'
    });
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: "{{ session('error') }}",
        confirmButtonColor: '#f27474'
    });
</script>
@endif

<script>
    $(document).ready(function () {
        $('.btn-detail').on('click', function () {
            const transaksiId = $(this).data('id');

            $('#detailTableBody').html('<tr><td colspan="4" class="text-center">Memuat...</td></tr>');
            $('#totalKeseluruhanDetail').text('Rp 0');

            $.get(`/admin/transaksi/detail/${transaksiId}`, function (res) {
                let html = '';
                let totalKeseluruhan = 0;

                if (res.data.details.length > 0) {
                    res.data.details.forEach(function (item) {
                        let subtotal = item.jumlah * item.barang.harga_satuan;
                        totalKeseluruhan += subtotal;

                        html += `
                            <tr>
                                <td>${item.barang.nama_barang}</td>
                                <td>${item.jumlah}</td>
                                <td>Rp ${parseInt(item.barang.harga_satuan).toLocaleString()}</td>
                                <td>Rp ${subtotal.toLocaleString()}</td>
                            </tr>`;
                    });
                } else {
                    html = '<tr><td colspan="4" class="text-center">Tidak ada detail.</td></tr>';
                }

                $('#detailTableBody').html(html);
                $('#totalKeseluruhanDetail').text('Rp ' + totalKeseluruhan.toLocaleString());
                $('#modalDetail').modal('show');
            });
        });

        
    });
    document.addEventListener('DOMContentLoaded', function () {
            const forms = document.querySelectorAll('.form-hapus');

            forms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault(); // Cegah form submit langsung

                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data ini akan dihapus permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Submit form jika dikonfirmasi
                        }
                    });
                });
            });
        });
</script>
@endpush
@endsection
