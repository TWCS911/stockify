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
        Schema::create('barang_masuks', function (Blueprint $table) {
            $table->string('id', 20)->primary(); // ID dengan prefix TRM-
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->string('supplier_id'); // FK ke suppliers.id_supplier (string), nanti buat FK manual
            $table->integer('jumlah');
            $table->timestamps();

            // Foreign key manual karena id_supplier bertipe string
            $table->foreign('supplier_id')->references('id_supplier')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuks');
    }
};
