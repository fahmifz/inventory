<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPemesananUlang extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pemesanan_ulang';

    protected $fillable = [
        'barang_id',
        'tanggal_pemesanan',
        'status',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
