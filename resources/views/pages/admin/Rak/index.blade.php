    @extends('layouts.app', ['title' => 'Rak Barang'])

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
                <h1>Rak Barang</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('admin.tambah') }}" class="btn btn-primary my-4">
                                    <i class="fas fa-plus"></i> Tambah Rak Barang
                                </a>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" id="table-rak">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Nama RAK</th>
                                            <th class="text-center">Kategori</th>
                                            <th class="text-center">Kapasitas</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rak as $index => $r)
                                    <tr>
                                        <th scope="row" class="text-center">{{ $index + 1 }}</th>
                                        <td class="text-center">{{ $r->rak }}</td>
                                        <td class="text-center">{{ $r->kategori }}</td>
                                        <td class="text-center">
                                            {{ $r->totalTerisi() }} / {{ $r->kapasitas }}
                                        </td>

                                        <td class="text-center">
                                            <a href="{{ route('admin.editrak', $r->id) }}" class="btn btn-warning my-2">
                                                <i class="fas fa-edit">edit</i>
                                            </a>
                                            <form action="{{ route('rak.delete', $r->id) }}" method="POST" class="form-hapus" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash-alt">hapus</i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
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
    @push('styles')
        <style>
            table.table-bordered th,
            table.table-bordered td {
                border: 1px solid #dee2e6 !important;
            }
        </style>
    @endpush

    @endpush
    @endsection