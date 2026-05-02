public function up(): void
{
    Schema::create('keranjang_item', function (Blueprint $table) {
        $table->id('id_item');
        $table->unsignedBigInteger('id_keranjang');
        $table->unsignedBigInteger('id_produk');
        $table->integer('jumlah_keranjang');
        $table->decimal('harga_satuan_keranjang', 15, 2);
        $table->decimal('subtotal_keranjang', 15, 2);
        $table->softDeletes();
        $table->timestamps();

        $table->foreign('id_keranjang')->references('id_keranjang')->on('keranjang');
    });
}