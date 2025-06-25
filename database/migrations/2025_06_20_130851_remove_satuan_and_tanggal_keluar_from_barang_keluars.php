<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSatuanAndTanggalKeluarFromBarangKeluars extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('barang_keluars', function (Blueprint $table) {
            // Hapus kolom satuan jika ada
            if (Schema::hasColumn('barang_keluars', 'satuan')) {
                $table->dropColumn('satuan');
            }

            // Hapus kolom tanggal_keluar jika ada
            if (Schema::hasColumn('barang_keluars', 'tanggal_keluar')) {
                $table->dropColumn('tanggal_keluar');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang_keluars', function (Blueprint $table) {
            // Jika ingin rollback, tambahkan kembali kolom satuan dan tanggal_keluar

            // Menambahkan kolom satuan jika perlu
            if (!Schema::hasColumn('barang_keluars', 'satuan')) {
                $table->string('satuan', 255);
            }

            // Menambahkan kolom tanggal_keluar jika perlu
            if (!Schema::hasColumn('barang_keluars', 'tanggal_keluar')) {
                $table->date('tanggal_keluar');
            }
        });
    }
}
