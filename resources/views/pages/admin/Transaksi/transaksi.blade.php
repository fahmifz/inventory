@extends('layouts.app', ['title' => 'Transaksi'])

@section('content')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endpush

<div class="main-content">
<section class="section">
<div class="section-header">
  <h1>🧾 Transaksi Penjualan</h1>
</div>

<form id="form-transaksi" action="{{ route('base.transaksi.store') }}" method="POST">
@csrf

<div class="card shadow-sm">
<div class="card-body">

{{-- TANGGAL --}}
<div class="form-group col-md-4 p-0">
<label class="font-weight-bold">Tanggal Transaksi</label>
<input type="date" name="tanggal_transaksi" class="form-control" value="{{ date('Y-m-d') }}">
</div>

<hr>
<h6 class="font-weight-bold mb-3">📦 Daftar Barang</h6>

<div id="barang-list">

<div class="barang-item border rounded p-3 mb-3 bg-light">
<div class="form-row align-items-end">

<div class="col-md-5">
<label>Barang</label>
<select name="barang_id[]" class="form-control barang-select" required>
<option value="">-- Pilih Barang --</option>
@foreach ($barangs as $barang)
<option 
value="{{ $barang->id }}"
data-harga="{{ $barang->harga_satuan }}"
data-stok="{{ $barang->jumlah_stok }}"
{{ $barang->jumlah_stok == 0 ? 'disabled' : '' }}>
{{ $barang->nama_barang }} (stok: {{ $barang->jumlah_stok }})
</option>
@endforeach
</select>
</div>

<div class="col-md-2">
<label>Stok</label>
<input type="text" class="form-control stok-field text-center font-weight-bold" readonly value="-">
</div>

<div class="col-md-2">
<label>Qty</label>
<input type="number" name="jumlah[]" class="form-control jumlah-input" min="1" value="1" required>
</div>

<div class="col-md-2">
<label>Subtotal</label>
<input type="text" class="form-control subtotal-field text-primary font-weight-bold" readonly value="Rp0">
</div>

<div class="col-md-1">
<button type="button" class="btn btn-danger btn-sm remove-barang">✕</button>
</div>

</div>
</div>

</div>

<button type="button" class="btn btn-outline-primary btn-sm mb-3" id="tambah-barang">
➕ Tambah Barang
</button>

<hr>

<div class="form-group">
<label class="font-weight-bold">Total Bayar</label>
<input type="text" id="total-harga" class="form-control form-control-lg text-primary font-weight-bold" readonly value="Rp0">
</div>

<div class="text-right">
<button class="btn btn-success px-4">💾 Simpan</button>
<a href="{{ route('base.transaksi') }}" class="btn btn-secondary">↩ Kembali</a>
</div>

</div>
</div>

</form>
</section>
</div>
@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

/* ===================== FORMAT RUPIAH ===================== */
function formatRupiah(angka){
return 'Rp' + Number(angka).toLocaleString('id-ID');
}

/* ===================== HITUNG TOTAL ===================== */
function updateTotal(){
let total = 0;

$('.barang-item').each(function(){

const select = $(this).find('.barang-select option:selected');
const harga = parseInt(select.data('harga')) || 0;
const stok  = select.data('stok') ?? '-';
const qty   = parseInt($(this).find('.jumlah-input').val()) || 0;

const subtotal = harga * qty;

$(this).find('.stok-field').val(stok);
$(this).find('.subtotal-field').val(formatRupiah(subtotal));

total += subtotal;
});

$('#total-harga').val(formatRupiah(total));
}

/* ===================== VALIDASI TOTAL STOK ===================== */
function cekTotalBarang(){

let data = {};

$('.barang-item').each(function(){

const id   = $(this).find('.barang-select').val();
const qty  = parseInt($(this).find('.jumlah-input').val()) || 0;
const stok = parseInt($(this).find('.barang-select option:selected').data('stok')) || 0;

if(!id) return;

if(!data[id])
data[id] = {qty:0, stok:stok};

data[id].qty += qty;

});

for(let id in data){
if(data[id].qty > data[id].stok){
Swal.fire('Stok Tidak Cukup','Total qty melebihi stok tersedia','error');
return false;
}
}

return true;
}

/* ===================== INIT SELECT2 ===================== */
function initSelect2(el = '.barang-select'){
$(el).select2({
width:'100%',
placeholder:'-- Pilih Barang --'
});
}

/* ===================== READY ===================== */
$(document).ready(function(){

initSelect2();

/* pilih barang */
$(document).on('change','.barang-select',function(){
updateTotal();
});

/* qty realtime */
$(document).on('input','.jumlah-input',function(){

const row  = $(this).closest('.barang-item');
const stok = parseInt(row.find('.barang-select option:selected').data('stok')) || 0;
let qty    = parseInt($(this).val()) || 0;

if(qty > stok){
Swal.fire('Stok Tidak Cukup','Maksimal '+stok,'error');
$(this).val(stok);
}

updateTotal();
});

/* tambah barang */
$('#tambah-barang').click(function(){

const clone = $('.barang-item').first().clone();

clone.find('.barang-select').select2('destroy');
clone.find('select').val('');
clone.find('.stok-field').val('-');
clone.find('.jumlah-input').val(1);
clone.find('.subtotal-field').val('Rp0');

$('#barang-list').append(clone);
initSelect2(clone.find('.barang-select'));
});

/* hapus barang */
$(document).on('click','.remove-barang',function(){

if($('.barang-item').length <= 1){
Swal.fire('Minimal 1 barang','Transaksi harus memiliki barang','warning');
return;
}

$(this).closest('.barang-item').remove();
updateTotal();
});

/* VALIDASI SAAT SUBMIT */
$('#form-transaksi').submit(function(e){
if(!cekTotalBarang()){
e.preventDefault();
}
});

});
</script>
@endpush