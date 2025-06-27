@extends('layouts.app', ['title' => 'Edit Data Guru RPPH'])

@section('content')
@push('styles')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Rak Barang</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('admin.updaterak', $r->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $r->id }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rak">Nama Rak</label>
                                            <input type="text" name="rak" class="form-control @error('rak') is-invalid @enderror" id="rak" value="{{ old('rak', $r->rak) }}">
                                            @error('rak')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                       <div class="form-group">
                                            <label for="kategori">Kategori</label>
                                            <input type="text" name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror" value="{{ old('kategori', $r->kategori) }}">
                                            @error('kategori')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                          <label for="kapasitas">Kapasitas</label>
                                            <input type="number" name="kapasitas" id="kapasitas" class="form-control @error('kapasitas') is-invalid @enderror"
                                                value="{{ old('kapasitas', $r->kapasitas) }}" required min="1">
                                            @error('kapasitas')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('admin.rak') }}" class="btn btn-warning">Kembali</a>
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
        });
    </script>
@endpush
@endsection