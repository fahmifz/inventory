<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Detail_Transaksi;
use Carbon\Carbon;

class Barang extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_barang',
        'kategori',
        'jumlah_stok',
        'satuan',
        'tanggal_masuk',
        'rak_id',
        'harga_satuan',
        'lead_time',
    ];

    public function rak()
    {
        return $this->belongsTo(Rak::class);
    }

    public function detailTransaksis()
    {
        return $this->hasMany(Detail_Transaksi::class);
    }

    public function hitungROP($hari = 7)
    {
        $leadTime = $this->lead_time ?? 1;
        $start = Carbon::now()->subDays($hari);

        // Ambil detail transaksi 7 hari terakhir dan load transaksi
        $transaksi = $this->detailTransaksis()
            ->whereHas('transaksi', function ($q) use ($start) {
                $q->where('tanggal_transaksi', '>=', $start);
            })
            ->with('transaksi')
            ->get();

        // Kelompokkan per tanggal
        $transaksiPerHari = $transaksi->groupBy(function($item) {
            return Carbon::parse($item->transaksi->tanggal_transaksi)->format('Y-m-d');
        });

        // Hitung jumlah per hari
        $dailySums = [];
        foreach ($transaksiPerHari as $items) {
            $dailySums[] = $items->sum('jumlah');
        }

        $averageDaily = collect($dailySums)->avg();

        return ceil($averageDaily * $leadTime);
    }


    public function getStatusStokAttribute()
    {
        return $this->jumlah_stok <= $this->hitungROP()
            ? 'Perlu Restock'
            : 'Aman';
    }
}
