<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Detail_Transaksi;
use App\Models\Transaksi;
use App\Models\RiwayatPemesananUlang;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::all();
        $totalKeseluruhan = Barang::all();
        return view('pages.admin.transaksi.index', compact('transaksi', 'totalKeseluruhan'));
    }

    public function transaksi()
    {
        $barangs = Barang::where('jumlah_stok', '>', 0)->get(); 
        return view('pages.admin.transaksi.transaksi', compact('barangs'));
    }

    public function createproses(Request $request)
{
    $request->validate([
        'tanggal_transaksi' => 'required|date',
        'barang_id' => 'required|array',
        'barang_id.*' => 'exists:barangs,id',
        'jumlah' => 'required|array',
        'jumlah.*' => 'integer|min:1',
    ]);

    $total_harga = 0;

    // Cek stok cukup & hitung total harga
    foreach ($request->barang_id as $index => $barang_id) {
        $barang = Barang::find($barang_id);
        $jumlah = $request->jumlah[$index];
        
        if ($barang->jumlah_stok < $jumlah) {
            return redirect()->back()->with('error', 'Stok barang "' . $barang->nama_barang . '" tidak mencukupi. Stok tersedia: ' . $barang->jumlah_stok);
        }

        $total_harga += $barang->harga_satuan * $jumlah;
    }

    // Simpan ke transaksi
    $transaksi = Transaksi::create([
        'tanggal_transaksi' => $request->tanggal_transaksi,
        'total_harga' => $total_harga,
    ]);

    // Proses setiap barang dalam transaksi
    foreach ($request->barang_id as $index => $barang_id) {
        $jumlah = $request->jumlah[$index];
        $barang = Barang::find($barang_id);

        // Simpan detail transaksi
        Detail_Transaksi::create([
            'transaksi_id' => $transaksi->id,
            'barang_id' => $barang_id,
            'jumlah' => $jumlah,
        ]);

        // Kurangi stok
        $barang->jumlah_stok -= $jumlah;
        $barang->save();

        // Hitung ROP setelah stok dikurangi
        $leadTime = $barang->lead_time ?? 1;
        $start = Carbon::now()->subDays(30);

        $totalJual = Detail_Transaksi::where('barang_id', $barang->id)
            ->whereHas('transaksi', function ($q) use ($start) {
                $q->where('tanggal_transaksi', '>=', $start);
            })
            ->sum('jumlah');

        $rataHarian = $totalJual / 30;
        $rop = ceil($rataHarian * $leadTime);

        // Jika stok di bawah ROP, dan belum tercatat, simpan ke riwayat
        if ($barang->jumlah_stok <= $rop) {
            $sudah_tercatat = RiwayatPemesananUlang::where('barang_id', $barang->id)
                ->where('status', 'pending')
                ->first();

            if (!$sudah_tercatat) {
                RiwayatPemesananUlang::create([
                    'barang_id' => $barang->id,
                    'status' => 'pending',
                    'tanggal_pemesanan' => now(),
                ]);
            }
        }
    }

    return redirect()->route('base.transaksi')->with('success', 'Transaksi berhasil dan stok dicek otomatis.');
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
