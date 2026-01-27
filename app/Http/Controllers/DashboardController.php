<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Rak;
use App\Models\Detail_Transaksi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data dasar
        $barang = Barang::all();
        $totalbarang = Barang::count();
        $totalrak = Rak::count();

        $data = [
            'totalbarang' => $totalbarang,
            'totalrak' => $totalrak,
        ];

        // ==============================
        // NOTIFIKASI REORDER POINT (ROP)
        // ==============================
        $notifROP = [];

        // Periode perhitungan rata-rata (hari)
        $periode = 30;
        $start = Carbon::now()->subDays($periode);

        foreach ($barang as $b) {

            // Lead time (default 1 hari jika kosong)
            $leadTime = $b->lead_time ?? 1;

            // Total penjualan 30 hari terakhir
            $totalJual = Detail_Transaksi::where('barang_id', $b->id)
                ->whereHas('transaksi', function ($q) use ($start) {
                    $q->where('tanggal_transaksi', '>=', $start);
                })
                ->sum('jumlah');

            // Rata-rata penjualan harian
            // Jika belum pernah terjual, diasumsikan minimal 1
            $rataHarian = $totalJual > 0
                ? ($totalJual / $periode)
                : 1;

            // Hitung ROP
            $rop = ceil($rataHarian * $leadTime);

            // Cek stok dengan ROP
            if ($b->jumlah_stok <= $rop) {
                $notifROP[] = [
                    'nama_barang' => $b->nama_barang,
                    'stok'        => $b->jumlah_stok,
                    'rop'         => $rop,
                ];
            }
        }

        return view('pages.admin.dashboard.index',compact('barang', 'data', 'notifROP')
        );
    }
}
