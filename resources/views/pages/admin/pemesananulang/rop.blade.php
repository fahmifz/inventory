@extends('layouts.app', ['title' => 'Riwayat Pemesanan Ulang'])

@section('content')
<div class="main-content">
    <section class="section">

        <div class="section-header">
            <h1>Riwayat Pemesanan Ulang</h1>
        </div>

        <div class="section-body">
            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-light text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Barang</th>
                                    <th>Tanggal Pemesanan</th>
                                    <th>Sisa Lead Time</th>
                                    <th>Status</th>
                                    <th>Ubah Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($riwayats as $index => $riwayat)
                                <tr class="text-center align-middle">

                                    <td>{{ $index + 1 }}</td>

                                    <td>
                                        <strong>{{ $riwayat->barang->nama_barang }}</strong>
                                    </td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($riwayat->tanggal_pemesanan)->format('d-m-Y') }}
                                    </td>

                                    {{-- SISA LEAD TIME --}}
                                    <td>
                                        @if ($riwayat->status != 'selesai')
                                            <span class="badge badge-info">
                                                {{ $riwayat->barang->sisaLeadTime() }} hari
                                            </span>
                                        @else
                                            <span class="badge badge-success">
                                                Barang Datang
                                            </span>
                                        @endif
                                    </td>

                                    {{-- STATUS --}}
                                    <td>
                                        @php
                                            $badge = [
                                                'pending'  => 'warning',
                                                'diproses' => 'primary',
                                                'selesai'  => 'success'
                                            ];
                                        @endphp

                                        <span class="badge badge-{{ $badge[$riwayat->status] }}">
                                            {{ ucfirst($riwayat->status) }}
                                        </span>
                                    </td>

                                    {{-- UBAH STATUS --}}
                                    <td>
                                        @if ($riwayat->status != 'selesai')
                                        <form action="{{ route('admin.riwayat.update', $riwayat->id) }}" method="POST">
                                            @csrf
                                            <select name="status"
                                                    class="form-control form-control-sm"
                                                    onchange="this.form.submit()">
                                                <option value="pending"
                                                    {{ $riwayat->status == 'pending' ? 'selected' : '' }}>
                                                    Pending
                                                </option>
                                                <option value="diproses"
                                                    {{ $riwayat->status == 'diproses' ? 'selected' : '' }}>
                                                    Diproses
                                                </option>
                                                <option value="selesai"
                                                    {{ $riwayat->status == 'selesai' ? 'selected' : '' }}>
                                                    Selesai
                                                </option>
                                            </select>
                                        </form>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        Tidak ada riwayat pemesanan ulang
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </section>
</div>
@endsection
