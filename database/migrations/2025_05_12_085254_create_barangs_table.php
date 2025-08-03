<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->string('kategori');
            $table->integer('jumlah_stok')->default(0);
            $table->integer('harga_satuan')->default(0); // tambahkan harga_satuan jika belum ada
            $table->integer('lead_time')->default(1); // dalam hari
            $table->string('satuan');
            $table->date('tanggal_masuk');
            $table->foreignId('rak_id')->constrained('raks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
