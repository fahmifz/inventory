@extends('layouts.app', ['title' => 'Edit Data Barang'])

@section('content')
@push('styles')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Data Barang</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('admin.update', $b->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_barang">Nama Barang</label>
                                            <input name="nama_barang" value="{{ old('nama_barang', $b->nama_barang) }}" type="text"
                                                class="form-control @error('nama_barang') is-invalid @enderror" id="nama_barang">
                                            @error('nama_barang')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="kat egori">Kategori</label>
                                            <input name="kategori" value="{{ old('kategori', $b->kategori) }}" type="text"
                                                class="form-control @error('kategori') is-invalid @enderror" id="kategori">
                                            @error('kategori')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>  

                                        <div class="form-group">
                                            <label for="jumlah_stok">Jumlah Stok</label>
                                            <input name="jumlah_stok" value="{{ old('jumlah_stok', $b->jumlah_stok) }}" type="number"
                                                class="form-control @error('jumlah_stok') is-invalid @enderror" id="jumlah_stok">
                                            @error('jumlah_stok')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="lead_time">Lead Time (hari)</label>
                                            <input name="lead_time" value="{{ old('lead_time', $b->lead_time) }}" type="number"
                                                class="form-control @error('lead_time') is-invalid @enderror" id="lead_time">
                                            @error('lead_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="harga_satuan">Harga Satuan (Rp)</label>
                                            <input name="harga_satuan" value="{{ old('harga_satuan', $b->harga_satuan) }}" type="number"
                                                class="form-control @error('harga_satuan') is-invalid @enderror" id="harga_satuan">
                                            @error('harga_satuan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="satuan">Satuan</label>
                                            <input name="satuan" value="{{ old('satuan', $b->satuan) }}" type="text"
                                                class="form-control @error('satuan') is-invalid @enderror" id="satuan">
                                            @error('satuan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="tanggal_masuk">Tanggal Masuk</label>
                                            <input name="tanggal_masuk" value="{{ old('tanggal_masuk', $b->tanggal_masuk) }}"
                                                type="date" class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                                id="tanggal_masuk">
                                            @error('tanggal_masuk')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="rak_id">Rak</label>
                                            <select name="rak_id" id="rak_id" class="form-control select2 @error('rak_id') is-invalid @enderror">
                                                <option value="">-- Pilih Rak --</option>
                                                @foreach($rak as $r)
                                                    <option value="{{ $r->id }}"
                                                        data-kapasitas="{{ $r->kapasitas }}"
                                                        data-terisi="{{ $r->totalTerisi() }}"
                                                        {{ old('rak_id', $b->rak_id) == $r->id ? 'selected' : '' }}>
                                                        {{ $r->rak }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small id="infoRak" class="text-info mt-2 d-block"></small>
                                            @error('rak_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('admin.barang') }}" class="btn btn-warning">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2();

            const rakSelect = document.getElementById('rak_id');
            const infoRak = document.getElementById('infoRak');

            function updateInfo() {
                const selected = rakSelect.options[rakSelect.selectedIndex];
                const kapasitas = selected.getAttribute('data-kapasitas');
                const terisi = selected.getAttribute('data-terisi');
                if (kapasitas && terisi) {
                    const sisa = kapasitas - terisi;
                    infoRak.innerText = `Kapasitas: ${kapasitas} | Terisi: ${terisi} | Sisa: ${sisa}`;
                } else {
                    infoRak.innerText = '';
                }
            }

            rakSelect.addEventListener('change', updateInfo);
            updateInfo(); // Jalankan saat load
        });
    </script>
@endpush
@endsection
