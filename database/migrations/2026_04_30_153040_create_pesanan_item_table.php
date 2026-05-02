public function up(): void
{
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