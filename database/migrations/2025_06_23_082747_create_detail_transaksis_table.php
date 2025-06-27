<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_transaksis', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->unsignedBigInteger('transaksi_id');
            $table->unsignedBigInteger('barang_id');

            // Data transaksi
            $table->integer('jumlah')->default(1);
            $table->decimal('harga_satuan', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2)->default(0);

            
            $table->timestamps();

            // Relasi
            $table->foreign('transaksi_id')->references('id')->on('transaksis')->onDelete('cascade');
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
    }
};
