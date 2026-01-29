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
        // =========================
        // DATA DASAR DASHBOARD
        // =========================
        $barang = Barang::all();
        $totalbarang = Barang::count();
        $totalrak = Rak::count();

        $data = [
            'totalbarang' => $totalbarang,
            'totalrak' => $totalrak,
        ];

        // =========================
        // PERHITUNGAN ROP
        // =========================
        $notifROP = [];

        $totalRestok = 0;

        $periode = 7; // hari
        $start = Carbon::now()->subDays($periode);

        $chartBarang = [];
        $chartStok   = [];
        $chartRop    = [];

        foreach ($barang as $b) {

            // Lead time default 1 hari
            $leadTime = $b->lead_time ?? 1;

            // Total penjualan 30 hari terakhir
            $totalJual = Detail_Transaksi::where('barang_id', $b->id)
                ->whereHas('transaksi', function ($q) use ($start) {
                    $q->where('tanggal_transaksi', '>=', $start);
                })
                ->sum('jumlah');

            // Rata-rata harian
            $rataHarian = $totalJual > 0 ? ($totalJual / $periode) : 1;

            // Hitung ROP
            $rop = ceil($rataHarian * $leadTime);

            // =========================
            // NOTIFIKASI RESTOK
            // =========================
            if ($b->jumlah_stok <= $rop) {

                $tambah = $rop - $b->jumlah_stok;
                $totalRestok += $tambah; // 🔥 akumulasi total restok

                $notifROP[] = [
                    'nama_barang' => $b->nama_barang,
                    'stok'        => $b->jumlah_stok,
                    'rop'         => $rop,
                    'tambah'      => $tambah,
                    'prioritas'   => $tambah
                ];
            }


            // =========================
            // DATA CHART
            // =========================
            $chartBarang[] = $b->nama_barang;
            $chartStok[]   = $b->jumlah_stok;
            $chartRop[]    = $rop;
        }

        // =========================
        // URUTKAN PRIORITAS RESTOK
        // =========================
        usort($notifROP, function ($a, $b) {
            return $b['prioritas'] <=> $a['prioritas'];
        });

        // Tambah ranking
        foreach ($notifROP as $i => $item) {
            $notifROP[$i]['rank'] = $i + 1;
        }

        // =========================
        // RETURN VIEW
        // =========================
        return view('pages.admin.dashboard.index', compact(
            'barang',
            'data',
            'notifROP',
            'chartBarang',
            'chartStok',
            'chartRop',
            'totalRestok'
        ));
    }
}
