<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric', // Bisa isi 100, 1000, bebas!
        ]);

        Product::create($request->all());
        return redirect()->route('products.index')->with('success', 'Barang berhasil ditambah!');
    }

    // Menyimpan perubahan data barang
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Data barang berhasil diupdate!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Barang berhasil dihapus!');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }
}