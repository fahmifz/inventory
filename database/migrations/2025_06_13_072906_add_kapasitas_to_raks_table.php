<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('raks', function (Blueprint $table) {
            $table->integer('kapasitas')->default(10)->after('rak'); // default kapasitas 10
        });
    }

    public function down()
    {
        Schema::table('raks', function (Blueprint $table) {
            $table->dropColumn('kapasitas');
        });
    }

};
