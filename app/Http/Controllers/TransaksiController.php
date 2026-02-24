<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Detail_Transaksi;
use App\Models\Transaksi;
use App\Models\RiwayatPemesananUlang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LAPORAN PER BARANG
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $barangs = Barang::whereHas('detailTransaksis')
            ->orderBy('nama_barang')
            ->get();

        return view('pages.admin.Transaksi.index', compact('barangs'));
    }

    public function laporanBarang()
    {
        $barangs = Barang::whereHas('detailTransaksis')
            ->orderBy('nama_barang')
            ->get();

        return view('pages.admin.Transaksi.index', compact('barangs'));
    }

    public function detailBarang($id)
    {
        $details = Detail_Transaksi::with('transaksi')
            ->where('barang_id', $id)
            ->latest()
            ->get();

        return response()->json($details);
    }


    /*
    |--------------------------------------------------------------------------
    | FORM TRANSAKSI
    |--------------------------------------------------------------------------
    */

    public function transaksi()
    {
        $barangs = Barang::where('jumlah_stok', '>', 0)->get();
        return view('pages.admin.Transaksi.transaksi', compact('barangs'));
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

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | VALIDASI TOTAL QTY PER BARANG
            |--------------------------------------------------------------------------
            */

            $cek = [];

            foreach ($request->barang_id as $i => $barangId) {

                $qty = $request->jumlah[$i];

                if (!isset($cek[$barangId])) {
                    $cek[$barangId] = 0;
                }

                $cek[$barangId] += $qty;
            }

            foreach ($cek as $barangId => $totalQty) {

                $barang = Barang::lockForUpdate()->findOrFail($barangId);

                if ($totalQty > $barang->jumlah_stok) {
                    DB::rollBack();
                    return back()->with(
                        'error',
                        'Total qty ' . $barang->nama_barang .
                        ' melebihi stok (stok tersedia ' . $barang->jumlah_stok . ')'
                    );
                }
            }


            /*
            |--------------------------------------------------------------------------
            | HITUNG TOTAL HARGA
            |--------------------------------------------------------------------------
            */

            $total_harga = 0;

            foreach ($request->barang_id as $i => $barangId) {
                $barang = Barang::findOrFail($barangId);
                $total_harga += $barang->harga_satuan * $request->jumlah[$i];
            }


            /*
            |--------------------------------------------------------------------------
            | SIMPAN TRANSAKSI
            |--------------------------------------------------------------------------
            */

            $transaksi = Transaksi::create([
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'total_harga' => $total_harga,
            ]);


            /*
            |--------------------------------------------------------------------------
            | SIMPAN DETAIL + UPDATE STOK + HITUNG ROP
            |--------------------------------------------------------------------------
            */

            foreach ($request->barang_id as $i => $barangId) {

                $qty = $request->jumlah[$i];
                $barang = Barang::findOrFail($barangId);

                // simpan detail
                Detail_Transaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id' => $barangId,
                    'jumlah' => $qty,
                ]);

                // kurangi stok
                $barang->jumlah_stok -= $qty;
                $barang->save();


                /*
                |--------------------------------------------------------------------------
                | HITUNG ROP (30 hari terakhir)
                |--------------------------------------------------------------------------
                */

                $leadTime = $barang->lead_time ?? 1;
                $start = Carbon::now()->subDays(30);

                $totalJual = Detail_Transaksi::where('barang_id', $barang->id)
                    ->whereHas('transaksi', function ($q) use ($start) {
                        $q->where('tanggal_transaksi', '>=', $start);
                    })
                    ->sum('jumlah');

                $rataHarian = $totalJual / 30;
                $rop = ceil($rataHarian * $leadTime);

                if ($barang->jumlah_stok <= $rop) {

                    $sudah = RiwayatPemesananUlang::where('barang_id', $barang->id)
                        ->where('status', 'pending')
                        ->exists();

                    if (!$sudah) {
                        RiwayatPemesananUlang::create([
                            'barang_id' => $barang->id,
                            'status' => 'pending',
                            'tanggal_pemesanan' => now(),
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('base.transaksi')
                ->with('success', 'Transaksi berhasil disimpan & stok diperbarui.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL PER TRANSAKSI (MODAL)
    |--------------------------------------------------------------------------
    */

    public function showDetail($id)
    {
        $transaksi = Transaksi::with(['details.barang'])->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $transaksi,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS TRANSAKSI
    |--------------------------------------------------------------------------
    */

    public function hapus($id)
    {
        DB::beginTransaction();

        try {

            $transaksi = Transaksi::with('details')->findOrFail($id);

            // kembalikan stok
            foreach ($transaksi->details as $detail) {

                $barang = Barang::find($detail->barang_id);
                if ($barang) {
                    $barang->jumlah_stok += $detail->jumlah;
                    $barang->save();
                }
            }

            $transaksi->details()->delete();
            $transaksi->delete();

            DB::commit();

            return back()->with('success', 'Transaksi berhasil dihapus & stok dikembalikan.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Gagal hapus transaksi.');
        }
    }
}