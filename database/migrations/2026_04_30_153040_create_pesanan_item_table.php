<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('pesanan_item');

        Schema::create('pesanan_item', function (Blueprint $table) {
            $table->id('id_pesanan_item');
            $table->unsignedBigInteger('id_pesanan');
            $table->unsignedBigInteger('id_produk');
            $table->integer('jumlah_pesanan');
            $table->decimal('harga_satuan_pesanan', 15, 2);
            $table->decimal('subtotal_pesanan', 15, 2);
            $table->timestamps();
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanans');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan_item');
    }
};