@extends('layouts.app', ['title' => 'Transaksi'])

@section('content')
@push('styles')
    <!-- SweetAlert2 & Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Input Transaksi Penjualan</h1>
    </div>

    <form action="{{ route('save.transaksi') }}" method="POST">
      @csrf
      <div class="card shadow">
        <div class="card-body">

          {{-- Tanggal Transaksi --}}
          <div class="form-group">
            <label for="tanggal">Tanggal Transaksi</label>
            <input type="date" name="tanggal_transaksi" class="form-control" value="{{ date('Y-m-d') }}">
          </div>

          {{-- Barang --}}
          <label>Daftar Barang</label>
          <div id="barang-list">
            <div class="form-row align-items-end mb-3 barang-item">
              <div class="col-md-4">
                <label>Barang</label>
                <select name="barang_id[]" class="form-control barang-select" onchange="updateTotal(this)">
                  <option value="">-- Pilih Barang --</option>
                  @foreach ($barangs as $barang)
                    <option 
                      value="{{ $barang->id }}" 
                      data-harga="{{ $barang->harga_satuan }}"
                      data-stok="{{ $barang->jumlah_stok }}">
                      {{ $barang->nama_barang }} - Rp{{ number_format($barang->harga_satuan, 0, ',', '.') }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2">
                <label>Stok</label>
                <input type="text" class="form-control stok-field" readonly value="-">
              </div>
              <div class="col-md-2">
                <label>Qty</label>
                <input type="number" name="jumlah[]" class="form-control jumlah-input" min="1" value="1" onchange="updateTotal()">
              </div>
              <div class="col-md-2">
                <label>Total</label>
                <input type="text" class="form-control subtotal-field" readonly value="Rp0">
              </div>
              <div class="col-md-2 text-right">
                <button type="button" class="btn btn-danger btn-sm remove-barang mt-4">Hapus</button>
              </div>
            </div>
          </div>

          <button type="button" class="btn btn-outline-secondary btn-sm mb-3" id="tambah-barang">+ Tambah Barang</button>

          {{-- Total Harga --}}
          <div class="form-group">
            <label>Total Harga</label>
            <input type="text" id="total-harga" class="form-control font-weight-bold text-primary" readonly value="Rp0">
          </div>

          <button class="btn btn-primary">Simpan Transaksi</button>
          <a href="{{ route('base.transaksi') }}" class="btn btn-warning">Kembali</a>

        </div>
      </div>
    </form>
  </section>
</div>
@endsection

@push('scripts')
<!-- jQuery & Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  function formatRupiah(angka) {
    return 'Rp' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  }

  function isDuplicateBarang(currentSelect) {
    const allSelects = document.querySelectorAll('.barang-select');
    const selectedValue = currentSelect.value;
    let count = 0;
    allSelects.forEach(select => {
      if (select.value === selectedValue) {
        count++;
      }
    });
    return count > 1;
  }

  function updateTotal(changedSelect = null) {
    let total = 0;
    const rows = document.querySelectorAll('.barang-item');

    rows.forEach(row => {
      const select = row.querySelector('.barang-select');
      const jumlahInput = row.querySelector('.jumlah-input');
      const subtotalField = row.querySelector('.subtotal-field');
      const stokField = row.querySelector('.stok-field');

      const selectedOption = select?.selectedOptions[0];
      const harga = parseInt(selectedOption?.dataset?.harga || 0);
      const stok = selectedOption?.dataset?.stok || '-';
      const jumlah = parseInt(jumlahInput?.value || 0);
      const subtotal = harga * jumlah;

      subtotalField.value = formatRupiah(subtotal);
      stokField.value = stok;
      total += subtotal;
    });

    document.getElementById('total-harga').value = formatRupiah(total);

    // Validasi duplikat barang
    if (changedSelect && isDuplicateBarang(changedSelect)) {
      Swal.fire({
        icon: 'warning',
        title: 'Barang Duplikat!',
        text: 'Barang yang sama tidak boleh dipilih lebih dari satu kali.',
        confirmButtonColor: '#f27474'
      });
      changedSelect.value = "";
      $(changedSelect).trigger('change'); // reset select2
      updateTotal();
    }
  }

  function applySelect2() {
    $('.barang-select').select2({
      placeholder: '-- Pilih Barang --',
      width: '100%'
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    applySelect2();
    updateTotal();
  });

  document.getElementById('tambah-barang').addEventListener('click', function () {
    const list = document.getElementById('barang-list');
    const originalItem = list.querySelector('.barang-item');

    $(originalItem.querySelector('.barang-select')).select2('destroy');

    const newItem = originalItem.cloneNode(true);
    newItem.querySelector('.barang-select').selectedIndex = 0;
    newItem.querySelector('.jumlah-input').value = 1;
    newItem.querySelector('.subtotal-field').value = 'Rp0';
    newItem.querySelector('.stok-field').value = '-';

    $(originalItem.querySelector('.barang-select')).select2({
      placeholder: '-- Pilih Barang --',
      width: '100%'
    });

    list.appendChild(newItem);
    $(newItem.querySelector('.barang-select')).select2({
      placeholder: '-- Pilih Barang --',
      width: '100%'
    });

    updateTotal();
  });

  document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-barang')) {
      const rows = document.querySelectorAll('.barang-item');
      if (rows.length > 1) {
        e.target.closest('.barang-item').remove();
        updateTotal();
      }
    }
  });
</script>

@if (session('success'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: "{{ session('success') }}",
    confirmButtonColor: '#48c2f6'
  });
</script>
@endif

@if (session('error'))
<script>
  Swal.fire({
    icon: 'error',
    title: 'Gagal',
    text: "{{ session('error') }}",
    confirmButtonColor: '#f27474'
  });
</script>
@endif
@endpush
