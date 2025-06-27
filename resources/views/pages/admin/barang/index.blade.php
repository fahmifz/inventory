@extends('layouts.app', ['title' => 'Data Barang'])

@section('content')
@push('styles')
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
     <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Barang</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {{-- Tombol Tambah --}}
                            <a href="{{ route('admin.tambahbarang') }}" class="btn btn-primary my-4">
                                <i class="fas fa-plus"></i> Tambah Data Barang
                            </a>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="table-barang">
                                    <thead>
                                        <tr class="text-dark text-center" style="white-space: nowrap;">
                                            <th class="text-center">#</th>
                                            <th class="text-center">Nama Barang</th>
                                            <th class="text-center">Stok</th>
                                            <th class="text-center">Harga satuan</th>
                                            <th class="text-center">Kategori</th>
                                            <th class="text-center">Kondisi Baik</th>
                                            <th class="text-center">Kondisi Buruk</th>
                                            <th class="text-center">Satuan</th>
                                            <th class="text-center">Tanggal Masuk</th>
                                            <th class="text-center">Tanggal Keluar</th>
                                            <th class="text-center">Rak</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($barang) == 0)
                                            <tr>
                                                <td colspan="10" class="text-center text-muted">Barang tidak ditemukan.</td>
                                            </tr>
                                        @else
                                            @foreach($barang as $index => $b)
                                            <tr class="text-dark" style="white-space: nowrap;">
                                                <th scope="row">{{ $index + 1 }}</th>
                                                <td class="text-center">{{ $b->nama_barang }}</td>
                                                <td class="text-center">{{ $b->jumlah_stok }}</td>
                                                <td class="text-center">{{ $b->harga_satuan }}</td>
                                                <td class="text-center">{{ $b->kategori }}</td>
                                                <td class="text-center">{{ $b->kondisi_baik }}</td>
                                                <td class="text-center">{{ $b->kondisi_buruk }}</td>
                                                <td class="text-center">{{ $b->satuan }}</td>
                                                <td class="text-center">{{ $b->tanggal_masuk }}</td>
                                                <td class="text-center">{{ $b->tanggal_keluar ?: '-' }}</td>
                                                <td class="text-center">{{ $b->rak ? $b->rak->rak : '-' }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.edit', $b->id) }}" class="btn btn-warning my-2">
                                                        <i class="fas fa-edit">edit</i>
                                                    </a>

                                                    <form action="{{ route('admin.delete', $b->id) }}" method="POST" class="form-hapus" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-trash-alt">hapus</i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
     <style>
        table.table-bordered th,
        table.table-bordered td {
            border: 1px solid #dee2e6 !important;
        }
    </style>
@endpush
@endsection