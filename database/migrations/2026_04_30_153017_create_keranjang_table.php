<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('keranjang_item'); // drop child dulu
        Schema::dropIfExists('keranjang');      // baru drop parent

        Schema::create('keranjang', function (Blueprint $table) {
            $table->id('id_keranjang');
            $table->unsignedBigInteger('user_id');
            $table->enum('status_keranjang', ['aktif', 'checkout'])->default('aktif');
            $table->date('tanggal_dibuat')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keranjang');
    }
};