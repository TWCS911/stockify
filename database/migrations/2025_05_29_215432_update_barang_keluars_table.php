<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('barang_keluars', function (Blueprint $table) {
            // Jika kolom-kolom belum ada, buat baru, jika sudah ada sesuaikan saja

            // Ubah kolom barang_id jadi foreign key ke barangs
            if (!Schema::hasColumn('barang_keluars', 'barang_id')) {
                $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            } else {
                // Jika sudah ada tapi bukan foreign key, kamu bisa drop dulu dan buat ulang foreign key
                // $table->dropForeign(['barang_id']);
                // $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            }

            // Ubah kolom satuan_id jadi foreign key ke satuan_barangs
            if (!Schema::hasColumn('barang_keluars', 'satuan_id')) {
                $table->foreignId('satuan_id')->constrained('satuan_barangs')->onDelete('cascade');
            }

            // Tambah kolom tanggal_keluar jika belum ada
            if (!Schema::hasColumn('barang_keluars', 'tanggal_keluar')) {
                $table->date('tanggal_keluar');
            }

            // Tambah kolom jumlah_keluar jika belum ada
            if (!Schema::hasColumn('barang_keluars', 'jumlah_keluar')) {
                $table->integer('jumlah_keluar')->default(0);
            }

            // Tambah kolom pembeli jika belum ada
            if (!Schema::hasColumn('barang_keluars', 'pembeli')) {
                $table->string('pembeli', 255);
            }

            // Tambah kolom no_telp jika belum ada
            if (!Schema::hasColumn('barang_keluars', 'no_telp')) {
                $table->string('no_telp', 255);
            }

            // ** Tambah kolom penjual **
            if (!Schema::hasColumn('barang_keluars', 'penjual')) {
                $table->string('penjual', 255)->after('no_telp'); // menambahkan setelah kolom no_telp
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang_keluars', function (Blueprint $table) {
            // Jika ingin rollback, hapus kolom yang baru ditambahkan
            if (Schema::hasColumn('barang_keluars', 'tanggal_keluar')) {
                $table->dropColumn('tanggal_keluar');
            }
            if (Schema::hasColumn('barang_keluars', 'jumlah_keluar')) {
                $table->dropColumn('jumlah_keluar');
            }
            if (Schema::hasColumn('barang_keluars', 'pembeli')) {
                $table->dropColumn('pembeli');
            }
            if (Schema::hasColumn('barang_keluars', 'no_telp')) {
                $table->dropColumn('no_telp');
            }

            // ** Drop kolom penjual jika ada **
            if (Schema::hasColumn('barang_keluars', 'penjual')) {
                $table->dropColumn('penjual');
            }

            // Jika kamu ingin juga menghapus foreign keys:
            if (Schema::hasColumn('barang_keluars', 'barang_id')) {
                $table->dropForeign(['barang_id']);
                $table->dropColumn('barang_id');
            }
            if (Schema::hasColumn('barang_keluars', 'satuan_id')) {
                $table->dropForeign(['satuan_id']);
                $table->dropColumn('satuan_id');
            }
        });
    }
};
