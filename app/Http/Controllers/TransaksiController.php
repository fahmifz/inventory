<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Detail_Transaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index() {
        $transaksi = Transaksi::all();
        $totalKeseluruhan = Barang::all();
        return view('pages.admin.transaksi.index',compact('transaksi','totalKeseluruhan'));
    }
    public function transaksi() {
        $barangs = Barang::all();
        $transaksi = Transaksi::all();
        return view('pages.admin.transaksi.transaksi',compact('barangs','transaksi'));
    }

    
   public function createproses(Request $request)
    {
        //  dd($request->all());
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'barang_id' => 'required|array',
            'barang_id.*' => 'exists:barangs,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
        ]);

        // Hitung total harga
        $total_harga = 0;
        foreach ($request->barang_id as $index => $barang_id) {
            $barang = Barang::find($barang_id);
            $jumlah = $request->jumlah[$index];
            $total_harga += $barang->harga_satuan * $jumlah;
        }

        // Simpan ke tabel transaksis
        $transaksi = Transaksi::create([
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'total_harga' => $total_harga,
            // 'jumlah_barang' => array_sum($request->jumlah),
        ]);

        // Simpan ke tabel detail_transaksis
        foreach ($request->barang_id as $index => $barang_id) {
            Detail_Transaksi::create([
                'transaksi_id' => $transaksi->id,
                'barang_id' => $barang_id,
                'jumlah' => $request->jumlah[$index],
            ]);
        }

        return redirect()->route('base.transaksi')->with('success', 'Transaksi berhasil disimpan.');
    }
        public function showDetail($id)
    {
        $transaksi = Transaksi::with(['details.barang'])->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $transaksi,
        ]);
    }
        public function hapus($id)
        {
            $transaksi = Transaksi::findOrFail($id);
            $transaksi->delete();
            return redirect()->route('base.transaksi')->with('success', 'Data berhasil dihapus.');
        }


    
}
