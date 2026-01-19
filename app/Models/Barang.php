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

    public function hitungROP($hari = 30)
    {
        $leadTime = $this->lead_time ?? 1;
        $start = Carbon::now()->subDays($hari);

        $totalJual = Detail_Transaksi::where('barang_id', $this->id)
            ->whereHas('transaksi', function ($q) use ($start) {
                $q->where('tanggal_transaksi', '>=', $start);
            })
            ->sum('jumlah');

        $rataHarian = $totalJual / $hari;

        return ceil($rataHarian * $leadTime);
    }

}
