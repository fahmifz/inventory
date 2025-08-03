<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom first_name dan last_name
            $table->dropColumn(['first_name', 'last_name']);

            // Tambahkan kembali kolom name
            $table->string('name')->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Rollback: tambahkan kembali first_name & last_name
            $table->string('first_name')->nullable()->after('id');
            $table->string('last_name')->nullable()->after('first_name');

            // Hapus kolom name
            $table->dropColumn('name');
        });
    }
};
