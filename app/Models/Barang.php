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
    | ROP CALCULATION (ROP = D × L)
    |--------------------------------------------------------------------------
    */

    public function hitungROP($hari = 30)
    {
        // Validasi agar tidak terjadi pembagian nol
        if ($hari <= 0) {
            $hari = 30;
        }

        $leadTime = $this->lead_time ?? 1;
        $start = Carbon::now()->subDays($hari);

        // Total penjualan dalam periode tertentu
        $totalTerjual = $this->detailTransaksis()
            ->whereHas('transaksi', function ($q) use ($start) {
                $q->whereDate('tanggal_transaksi', '>=', $start);
            })
            ->sum('jumlah');

        // Rata-rata permintaan per hari
        $averageDaily = $totalTerjual > 0
            ? $totalTerjual / $hari
            : 0;

        // ROP = D × L
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

        // Jika belum pernah melakukan pemesanan
        if (!$riwayat) {
            return 0;
        }

        $leadTime = $this->lead_time ?? 0;

        $hariBerjalan = Carbon::parse($riwayat->tanggal_pemesanan)
            ->diffInDays(now());

        $sisa = $leadTime - $hariBerjalan;

        return max($sisa, 0);
    }

    public function getStatusLeadTimeAttribute()
    {
        $riwayat = $this->riwayatPemesananUlang()
            ->whereIn('status', ['pending', 'diproses'])
            ->latest()
            ->first();

        if (!$riwayat) {
            return 'Belum Ada Pemesanan';
        }

        return $this->sisaLeadTime() > 0
            ? 'Dalam Pengiriman'
            : 'Selesai';
    }
}