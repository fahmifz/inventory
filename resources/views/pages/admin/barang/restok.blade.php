@extends('layouts.app', ['title' => 'Barang Perlu Restock'])

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Barang Restock</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">Dashboard</div>
                <div class="breadcrumb-item">Restok Barang</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Barang yang Perlu Restock</h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="text-center bg-light">
                                <tr>
                                    <th style="width: 40px">#</th>
                                    <th>Nama Barang</th>
                                    <th style="width: 80px">Stok</th>
                                    <th style="width: 80px">Reorder  point</th>
                                    <th style="width: 130px">Status</th>
                                    @if (Auth::user()->role === 'admin')
                                    <th style="width: 160px">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($restok as $index => $b)
                                <tr class="text-center">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="text-left">{{ $b->nama_barang }}</td>
                                    <td>{{ $b->jumlah_stok }}</td>
                                    <td>{{ $b->rop }}</td>
                                    <td>
                                        <span class="badge badge-danger px-3 py-2">
                                            Perlu Restock
                                        </span>
                                    </td>
                                    @if (Auth::user()->role === 'admin')
                                    <td>
                                        <form action="{{ route('admin.prosesRestok', $b->id) }}"
                                              method="POST"
                                              class="d-flex justify-content-center align-items-center">
                                            @csrf

                                            <input type="number"
                                                   name="jumlah_restok"
                                                   class="form-control form-control-sm text-center mr-2"
                                                   style="width: 70px"
                                                   min="1"
                                                   placeholder="Qty"
                                                   required>

                                            <button type="submit"
                                                    class="btn btn-success btn-sm"
                                                    title="Restok Barang">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-box-open mr-1"></i>
                                        Tidak ada barang yang perlu restock
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer text-muted small">
                    <i class="fas fa-info-circle"></i>
                    Barang akan otomatis hilang dari daftar ini setelah stok melebihi ROP.
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    table.table th,
    table.table td {
        vertical-align: middle !important;
        white-space: nowrap;
    }

    .badge {
        font-size: 0.85rem;
    }
</style>
@endpush
