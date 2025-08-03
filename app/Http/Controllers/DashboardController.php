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
        $barang = Barang::all();
        $totalbarang = Barang::count();
        $totalrak = Rak::count();

        $data = [
            'totalbarang' => $totalbarang,
            'totalrak' => $totalrak,
        ];

        // NOTIFIKASI ROP
        $notifROP = [];
        foreach ($barang as $b) {
            $leadTime = $b->lead_time;
            $start = Carbon::now()->subDays(30);

            $totalJual = Detail_Transaksi::where('barang_id', $b->id)
                ->whereHas('transaksi', function ($q) use ($start) {
                    $q->where('tanggal_transaksi', '>=', $start);
                })
                ->sum('jumlah');

            $rataHarian = $totalJual / 30;
            $rop = ceil($rataHarian * $leadTime);

            if ($b->jumlah_stok <= $rop) {
                $notifROP[] = [
                    'nama_barang' => $b->nama_barang,
                    'stok' => $b->jumlah_stok,
                    'rop' => $rop
                ];
            }
        }
        // dd($notifROP);
        return view('pages.admin.dashboard.index', compact('barang', 'data', 'notifROP'));
    }
}
