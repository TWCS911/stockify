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
        Schema::table('barang_masuks', function (Blueprint $table) {
            $table->date('tanggal_masuk')->nullable();  // Kolom baru untuk tanggal masuk
        });
    }

    public function down()
    {
        Schema::table('barang_masuks', function (Blueprint $table) {
            $table->dropColumn('tanggal_masuk');
        });
    }

};
