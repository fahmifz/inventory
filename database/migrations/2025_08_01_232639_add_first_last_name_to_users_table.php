<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom baru
            $table->string('first_name')->nullable()->after('id');
            $table->string('last_name')->nullable()->after('first_name');

            // Opsional: hapus kolom name jika tidak digunakan lagi
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse migrasi.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Balikkan perubahan
            $table->dropColumn(['first_name', 'last_name']);

            // Kembalikan kolom name jika dihapus
            $table->string('name')->nullable();
        });
    }
};
