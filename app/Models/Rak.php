<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    use HasFactory;
     protected $fillable = [
        'rak',
        'kategori',
        'kapasitas',
    ];
    
    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }
    public function totalTerisi()
    {
        return $this->barangs()->sum('kondisi_baik');
    }

}
