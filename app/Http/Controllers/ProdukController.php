public function show($id)
{
    $produk = \App\Models\Produk::findOrFail($id);
    return view('produk.show', compact('produk'));
}