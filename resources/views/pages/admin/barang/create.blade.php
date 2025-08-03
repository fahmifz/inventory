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
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Barang</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.tambahproses') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            {{-- Kolom kiri --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <input type="text" name="nama_barang" class="form-control" required value="{{ old('nama_barang') }}">
                                    @error('nama_barang') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group">
                                    <label>Jumlah Stok</label>
                                    <input type="number" name="jumlah_stok" class="form-control" required value="{{ old('jumlah_stok') }}">
                                    @error('jumlah_stok') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group">
                                    <label>Harga Satuan (Rp)</label>
                                    <input type="number" name="harga_satuan" class="form-control" required value="{{ old('harga_satuan') }}">
                                    @error('harga_satuan') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group">
                                    <label>Lead Time (hari)</label>
                                    <input type="number" name="lead_time" class="form-control" required value="{{ old('lead_time') }}">
                                    @error('lead_time') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            {{-- Kolom kanan --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <input type="text" name="kategori" class="form-control" required value="{{ old('kategori') }}">
                                    @error('kategori') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group">
                                    <label>Satuan</label>
                                    <input type="text" name="satuan" class="form-control" required value="{{ old('satuan') }}">
                                    @error('satuan') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group">
                                    <label>Tanggal Masuk</label>
                                    <input type="date" name="tanggal_masuk" class="form-control" required value="{{ old('tanggal_masuk') }}">
                                    @error('tanggal_masuk') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group">
                                    <label>Rak</label>
                                    <select name="rak_id" class="form-control selectric" id="rak_id" required>
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
                        </div>

                        {{-- Tombol --}}
                        <div class="text-right">
                            <button class="btn btn-primary">Simpan</button>
                            <a href="{{ route('admin.barang') }}" class="btn btn-warning">Kembali</a>
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

    const formatAngka = (angka) => new Intl.NumberFormat('id-ID').format(angka);

    function updateInfo() {
        const selected = rakSelect.options[rakSelect.selectedIndex];
        const kapasitas = selected.getAttribute('data-kapasitas');
        const terisi = selected.getAttribute('data-terisi');

        if (rakSelect.value && kapasitas && terisi) {
            const sisa = kapasitas - terisi;
            infoRak.innerText = `Kapasitas: ${formatAngka(kapasitas)} | Terisi: ${formatAngka(terisi)} | Sisa: ${formatAngka(sisa)}`;
            infoRak.className = sisa <= 5 ? 'text-danger mt-2 d-block' : 'text-info mt-2 d-block';
        } else {
            infoRak.innerText = '';
        }
    }

    rakSelect.addEventListener('change', updateInfo);
    updateInfo();
});
</script>
@endpush
@endsection
