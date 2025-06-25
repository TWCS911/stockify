<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSatuanIdAndTanggalKeluarFromBarangKeluars extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('barang_keluars', function (Blueprint $table) {
            // Hapus foreign key constraint untuk satuan_id jika ada
            if (Schema::hasColumn('barang_keluars', 'satuan_id')) {
                // Menyebutkan nama foreign key constraint yang terhubung dengan kolom satuan_id
                $table->dropForeign(['satuan_id']);
            }

            // Hapus kolom satuan_id jika ada
            if (Schema::hasColumn('barang_keluars', 'satuan_id')) {
                $table->dropColumn('satuan_id');
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
            // Jika ingin rollback, tambahkan kembali kolom satuan_id dan tanggal_keluar

            // Menambahkan kolom satuan_id jika perlu
            if (!Schema::hasColumn('barang_keluars', 'satuan_id')) {
                $table->foreignId('satuan_id')->constrained('satuan_barangs')->onDelete('cascade');
            }

            // Menambahkan kolom tanggal_keluar jika perlu
            if (!Schema::hasColumn('barang_keluars', 'tanggal_keluar')) {
                $table->date('tanggal_keluar');
            }
        });
    }
}
