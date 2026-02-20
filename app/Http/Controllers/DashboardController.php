<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Rak;

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
            'totalrak'    => $totalrak,
        ];

        // =========================
        // NOTIFIKASI ROP
        // =========================
        $notifROP = [];
        $totalRestok = 0;
        $chartBarang = [];
        $chartStok   = [];
        $chartRop    = [];

        foreach ($barang as $b) {

            // 🔥 Gunakan fungsi dari model (agar konsisten)
            $rop = $b->hitungROP();

            // =========================
            // NOTIFIKASI RESTOK
            // =========================
            if ($b->jumlah_stok <= $rop) {

                $tambah = $rop - $b->jumlah_stok;
                $totalRestok += $tambah;
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