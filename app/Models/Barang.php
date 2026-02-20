<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    protected $casts = [
        'tanggal_masuk' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    public function rak()
    {
        return $this->belongsTo(Rak::class);
    }

    public function detailTransaksis()
    {
        return $this->hasMany(Detail_Transaksi::class);
    }

    public function riwayatPemesananUlang()
    {
        return $this->hasMany(RiwayatPemesananUlang::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ROP CALCULATION
    |--------------------------------------------------------------------------
    */

    public function hitungROP($hari = 7)
    {
        $leadTime = $this->lead_time ?? 1;
        $start = Carbon::now()->subDays($hari);

        // total penjualan dalam periode
        $totalTerjual = $this->detailTransaksis()
            ->whereHas('transaksi', function ($q) use ($start) {
                $q->whereDate('tanggal_transaksi', '>=', $start);
            })
            ->sum('jumlah');

        // rata-rata per hari
        $averageDaily = $totalTerjual > 0
            ? $totalTerjual / $hari
            : 0;

        // ROP final
        return (int) ceil($averageDaily * $leadTime);
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS STOK
    |--------------------------------------------------------------------------
    */

    public function getStatusStokAttribute()
    {
        return $this->jumlah_stok <= $this->hitungROP()
            ? 'Perlu Restock'
            : 'Aman';
    }

    /*
    |--------------------------------------------------------------------------
    | SISA LEAD TIME
    |--------------------------------------------------------------------------
    */

    public function sisaLeadTime()
    {
        $riwayat = $this->riwayatPemesananUlang()
            ->whereIn('status', ['pending', 'diproses'])
            ->latest()
            ->first();

        // belum pernah order
        if (!$riwayat) {
            return $this->lead_time ?? 0;
        }

        $hariBerjalan = Carbon::parse($riwayat->tanggal_pemesanan)
            ->diffInDays(now());

        $sisa = ($this->lead_time ?? 0) - $hariBerjalan;

        return max($sisa, 0);
    }

    public function getStatusLeadTimeAttribute()
    {
        return $this->sisaLeadTime() > 0
            ? 'Dalam Pengiriman'
            : 'Selesai';
    }
}