<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_pemesanan_ulang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->enum('status', ['pending', 'diproses', 'selesai'])->default('pending');
            $table->timestamps(); // created_at = kapan direkam
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_pemesanan_ulang');
    }
};
