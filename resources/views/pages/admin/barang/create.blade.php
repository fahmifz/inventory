@extends('layouts.app', ['title' => 'Data barang'])
@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
<link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
@endpush

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Data Barang</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <form action="{{ route('admin.tambahproses') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Tambah Barang</h4>
                            </div>
                            <div class="card-body">

                                {{-- Pesan error umum --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                {{-- Nama Barang --}}
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Nama Barang</label>
                                    <div class="col-md-7">
                                        <input required type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang') }}">
                                        @error('nama_barang') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                {{-- Jumlah Stok --}}
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Jumlah stok</label>
                                    <div class="col-md-7">
                                        <input required type="number" name="jumlah_stok" class="form-control" value="{{ old('jumlah_stok') }}">
                                        @error('jumlah_stok') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                {{-- Harga Satuan --}}
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Harga Satuan (Rp)</label>
                                    <div class="col-md-7">
                                        <input required type="number" name="harga_satuan" class="form-control" value="{{ old('harga_satuan') }}">
                                        @error('harga_satuan') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                {{-- Kategori --}}
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Kategori</label>
                                    <div class="col-md-7">
                                        <input required type="text" name="kategori" class="form-control" value="{{ old('kategori') }}">
                                        @error('kategori') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                {{-- Kondisi Baik --}}
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Kondisi baik</label>
                                    <div class="col-md-7">
                                        <input required type="number" name="kondisi_baik" class="form-control" value="{{ old('kondisi_baik') }}">
                                        @error('kondisi_baik') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                {{-- Kondisi Buruk --}}
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Kondisi buruk</label>
                                    <div class="col-md-7">
                                        <input required type="number" name="kondisi_buruk" class="form-control" value="{{ old('kondisi_buruk') }}">
                                        @error('kondisi_buruk') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                {{-- Satuan --}}
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Satuan</label>
                                    <div class="col-md-7">
                                        <input required type="text" name="satuan" class="form-control" value="{{ old('satuan') }}">
                                        @error('satuan') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                {{-- Tanggal Masuk --}}
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Tanggal Masuk</label>
                                    <div class="col-md-7">
                                        <input required type="date" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk') }}">
                                        @error('tanggal_masuk') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                {{-- Tanggal Keluar --}}
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Tanggal Keluar</label>
                                    <div class="col-md-7">
                                        <input type="date" name="tanggal_keluar" class="form-control" value="{{ old('tanggal_keluar') }}">
                                        @error('tanggal_keluar') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                {{-- Rak --}}
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Rak</label>
                                    <div class="col-md-7">
                                        <select required name="rak_id" class="form-control selectric" id="rak_id">
                                            <option value="">-- Pilih Rak --</option>
                                            @foreach($raks as $rak)
                                                <option 
                                                    value="{{ $rak->id }}" 
                                                    data-kapasitas="{{ $rak->kapasitas }}" 
                                                    data-terisi="{{ $rak->totalTerisi() }}"
                                                    {{ old('rak_id') == $rak->id ? 'selected' : '' }}>
                                                    {{ $rak->rak }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small id="infoRak" class="text-info mt-2 d-block"></small>

                                        @error('rak_id') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                {{-- Tombol --}}
                                <div class="form-group row">
                                    <div class="col-md-7 offset-md-3">
                                        <button class="btn btn-primary">Simpan</button>
                                        <a href="{{ route('admin.barang') }}" class="btn btn-warning">Kembali</a>
                                    </div>
                                </div>
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
<script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
<script src="{{ asset('library/upload-preview/upload-preview.js') }}"></script>
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const rakSelect = document.getElementById('rak_id');
    const infoRak = document.getElementById('infoRak');

    // Fungsi format angka (biar rapi: 1,000)
    const formatAngka = (angka) => {
        return new Intl.NumberFormat('id-ID').format(angka);
    };

    function updateInfo() {
    const selected = rakSelect.options[rakSelect.selectedIndex];
    const kapasitas = selected.getAttribute('data-kapasitas');
    const terisi = selected.getAttribute('data-terisi');

    if (rakSelect.value !== "" && kapasitas && terisi) {
        const sisa = kapasitas - terisi;

        infoRak.innerText = `Kapasitas: ${formatAngka(kapasitas)} | Terisi: ${formatAngka(terisi)} | Sisa: ${formatAngka(sisa)}`;

        if (sisa <= 5) {
            infoRak.classList.remove('text-info');
            infoRak.classList.add('text-danger');
        } else {
            infoRak.classList.remove('text-danger');
            infoRak.classList.add('text-info');
        }

    } else {
        infoRak.innerText = '';
    }
}


    rakSelect.addEventListener('change', updateInfo);
    updateInfo(); // jalankan saat halaman dimuat
});
</script>
@endpush
@endsection
