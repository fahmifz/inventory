@extends('layouts.app', ['title' => 'Laporan Penjualan Barang'])

@section('content')
<style>
.dot-merah{
    height:10px;
    width:10px;
    background:red;
    border-radius:50%;
    display:inline-block;
    margin-left:5px;
}
</style>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Laporan Penjualan Barang</h1>
        </div>

        <div class="section-body">
            @if (Auth::user()->role === 'staff')
            <a href="{{ route('base.transaksi.create') }}" class="btn btn-primary mb-3">TAMBAH TRANSAKSI</a>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="text-center">
                            <tr>
                                <th>#</th>
                                <th>Nama Barang</th>
                                <th>Harga Satuan</th>
                                <th>Detail</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($barangs as $index => $barang)
                            <tr>

                                <td class="text-center">{{ $index + 1 }}</td>

                                <td>
                                    {{ $barang->nama_barang }}

                                    <span id="dot-{{ $barang->id }}" class="dot-merah"></span>
                                </td>

                                <td class="text-right">
                                    Rp {{ number_format($barang->harga_satuan, 0, ',', '.') }}
                                </td>

                                <td class="text-center">

                                    <button 
                                        class="btn btn-info btn-detail-barang"
                                        data-id="{{ $barang->id }}">
                                        Detail
                                    </button>

                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL HISTORI -->
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Histori Penjualan Barang</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">

                <thead class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Tanggal Transaksi</th>
                        <th>Jumlah Terjual</th>
                    </tr>
                </thead>
                <tbody id="detailTableBody">
                    <tr>
                        <td colspan="3" class="text-center">Memuat...</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-right">Total Terjual</th>
                        <th class="text-center" id="totalTerjual">0</th>
                    </tr>
                </tfoot>

                </table>
            </div>
        </div>
    </div>
</div>

@endsection


@push('scripts')
<script>

$(document).ready(function () {

    $(".dot-merah").each(function(){

        let id = $(this).attr('id').replace("dot-","");
        let waktuTransaksi = $(this).data('waktu');

        let terakhirBuka = localStorage.getItem("dibaca_"+id);

        // tampilkan hanya kalau transaksi lebih baru
        if(!terakhirBuka || waktuTransaksi > terakhirBuka){
            $(this).show();
        }else{
            $(this).hide();
        }

    });


    $(document).on('click', '.btn-detail-barang', function () {

        let barangId = $(this).data('id');

        let waktuSekarang = new Date().toISOString();

        localStorage.setItem("dibaca_"+barangId, waktuSekarang);

        $("#dot-"+barangId).hide();


        $('#detailTableBody').html(
            '<tr><td colspan="3" class="text-center">Memuat...</td></tr>'
        );


        $.ajax({
            url: "/admin/laporan/barang/" + barangId,
            type: "GET",
            success: function (response) {

                let html = '';
                let total = 0;

                response.forEach(function (item, index) {

                    total += parseInt(item.jumlah);

                    html += `
                    <tr>
                        <td class="text-center">${index + 1}</td>
                        <td class="text-center">${item.transaksi.tanggal_transaksi}</td>
                        <td class="text-center">${item.jumlah}</td>
                    </tr>
                    `;
                });

                $('#detailTableBody').html(html);
                $('#totalTerjual').text(total);
                $('#modalDetail').modal('show');

            }

        });

    });

});

</script>
@endpush