<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('pembayarans');

        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->unsignedBigInteger('id_pesanan');
            $table->enum('metode_pembayaran', ['transfer','cod','ewallet']);
            $table->enum('status_pembayaran', ['menunggu','lunas','gagal'])->default('menunggu');
            $table->date('tanggal_bayar')->nullable();
            $table->decimal('jumlah_bayar', 15, 2);
            $table->timestamps();
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanans');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};