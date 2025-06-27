<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_barang',
        'kategori',
        'kondisi_baik',
        'kondisi_buruk',
        'jumlah_stok',
        'satuan',
        'tanggal_masuk',
        'tanggal_keluar',
        'rak_id',
        'harga_satuan',
        
    ];

    public function rak()
    {
        return $this->belongsTo(Rak::class);
    }
     public function detailTransaksis()
    {
        return $this->hasMany(Detail_Transaksi::class);
    }

}
