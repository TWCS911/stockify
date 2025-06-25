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
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropForeign(['satuan_barang_id']);
            $table->dropColumn('satuan_barang_id');
            $table->string('satuan')->after('jumlah');
        });
    }

    public function down()
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->foreignId('satuan_barang_id')->constrained('satuan_barangs')->onDelete('cascade');
            $table->dropColumn('satuan');
        });
    }

};
