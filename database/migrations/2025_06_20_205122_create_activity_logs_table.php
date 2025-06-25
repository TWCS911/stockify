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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');  // ID user yang melakukan aksi
            $table->string('action');               // Deskripsi aksi yang dilakukan
            $table->string('model');                // Nama model yang terpengaruh
            $table->text('data')->nullable();      // Data yang terpengaruh (misalnya, data yang diubah)
            $table->timestamps();

            // Relasi ke tabel users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }

};
