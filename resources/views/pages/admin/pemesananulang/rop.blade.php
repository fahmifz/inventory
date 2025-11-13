@extends('layouts.app', ['title' => 'Riwayat Pemesanan Ulang'])

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Riwayat Pemesanan Ulang</h1>
        </div>

        <div class="section-body">
            <div class="card shadow">
                <div class="card-body">

                    {{-- Tombol hapus banyak --}}
                    <form id="multiDeleteForm" action="{{ route('admin.riwayat.deleteMultiple') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data terpilih?')">
                                <i class="fas fa-trash"></i> Hapus Terpilih
                            </button>
                        </div>

                        <table class="table table-bordered table-hover">
                            <thead class="bg-light text-center">
                                <tr>
                                    <th><input type="checkbox" id="selectAll"></th>
                                    <th>#</th>
                                    <th>Nama Barang</th>
                                    <th>Tanggal Pemesanan</th>
                                    <th>Status</th>
                                    <th>Ubah Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($riwayats as $index => $riwayat)
                                <tr class="text-center">
                                    <td><input type="checkbox" name="selected[]" value="{{ $riwayat->id }}"></td>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $riwayat->barang->nama_barang }}</td>
                                    <td>{{ \Carbon\Carbon::parse($riwayat->tanggal_pemesanan)->format('d-m-Y') }}</td>
                                    <td>
                                        @php
                                            $badge = [
                                                'pending' => 'warning',
                                                'diproses' => 'primary',
                                                'selesai' => 'success'
                                            ];
                                        @endphp
                                        <span class="badge badge-{{ $badge[$riwayat->status] }}">
                                            {{ ucfirst($riwayat->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.riwayat.update', $riwayat->id) }}" method="POST">
                                            @csrf
                                            <select name="status" onchange="this.form.submit()" class="form-control">
                                                <option value="pending" {{ $riwayat->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="diproses" {{ $riwayat->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                                <option value="selesai" {{ $riwayat->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Tidak ada riwayat.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- Script Select All --}}
<script>
    document.getElementById('selectAll').addEventListener('click', function(e) {
        const checkboxes = document.querySelectorAll('input[name="selected[]"]');
        checkboxes.forEach(cb => cb.checked = e.target.checked);
    });
</script>
@endsection
