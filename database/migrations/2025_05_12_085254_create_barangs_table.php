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
            $table->integer('kondisi_baik')->default(0);
            $table->integer('kondisi_buruk')->default(0);
            $table->integer('jumlah_stok')->default(0);
            $table->string('satuan');
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar')->nullable();
            $table->foreignId('rak_id')->constrained('raks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
