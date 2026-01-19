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

                    <table class="table table-bordered table-hover">
                        <thead class="bg-light text-center">
                            <tr>
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
                                <td colspan="5" class="text-center text-muted">Tidak ada riwayat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </section>
</div>
@endsection
