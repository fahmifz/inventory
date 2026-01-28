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
                            <div class="d-flex justify-content-between align-items-center mb-4">
                            {{-- Tombol Tambah di kiri --}}
                            @if (Auth::user()->role == 'admin')
                            <a href="{{ route('admin.tambahbarang') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Data Barang
                            </a>
                            @endif

                        {{-- Form Pencarian di kanan --}}
                        <form action="{{ route('admin.barang') }}" method="GET" style="max-width: 300px; width: 100%;">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari nama barang..." value="{{ request('search') }}">
                                
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search">Cari</i>
                                    </button>

                                    <a href="{{ route('admin.barang') }}" class="btn btn-secondary">
                                        <i class="fas fa-sync-alt">Reset</i>
                                    </a>
                                </div>
                            </div>
                        </form>
                </div>
                            {{-- Tabel Data Barang --}} 
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="table-barang">
                                    <thead>
                                        <tr class="text-dark text-center" style="white-space: nowrap;">
                                            <th class="text-center">#</th>
                                            <th class="text-center">Nama Barang</th>
                                            <th class="text-center">Stok</th>
                                            <th class="text-center">ROP</th>
                                            <th class="text-center">Status Stok</th>
                                            <th class="text-center">Harga satuan</th>
                                            <th class="text-center">Kategori</th>
                                            <th class="text-center">Satuan</th>
                                            <th class="text-center">Tanggal Masuk</th>
                                            <th class="text-center">Rak</th>
                                            @if (Auth::user()->role === 'admin')
                                            <th class="text-center">lead-time</th>
                                            @endif
                                            @if (Auth::user()->role === 'admin')
                                            <th class="text-center">Action</th>
                                            @endif
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
                                                {{-- ROP --}}
                                                <td class="text-center">{{ $b->rop }}</td>
                                                {{-- STATUS --}}
                                                <td class="text-center">
                                                    @if($b->status_stok === 'Perlu Restock')
                                                        <span class="badge badge-danger">Perlu Restock</span>
                                                    @else
                                                        <span class="badge badge-success">Aman</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $b->harga_satuan }}</td>
                                                <td class="text-center">{{ $b->kategori }}</td>
                                                <td class="text-center">{{ $b->satuan }}</td>
                                                <td class="text-center">{{ $b->tanggal_masuk }}</td>
                                                <td class="text-center">{{ $b->rak ? $b->rak->rak : '-' }}</td>
                                                @if (Auth::user()->role === 'admin')
                                                <td class="text-center">{{ $b->lead_time }}</td>
                                                @endif
                                                @if (Auth::user()->role === 'admin')
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
                                                @endif
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