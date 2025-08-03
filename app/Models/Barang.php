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

    public function hitungROP()
    {
        $start = Carbon::now()->subDays(30);

        $total_jual = Detail_Transaksi::where('barang_id', $this->id)
            ->whereHas('transaksi', function ($q) use ($start) {
                $q->where('tanggal_transaksi', '>=', $start);
            })
            ->sum('jumlah');

        $rata_rata = $total_jual / 30;

        return ceil($rata_rata * $this->lead_time);
    }
}
