@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-md">
    <h2 class="text-2xl font-bold mb-6">Edit Data Barang</h2>
    
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block font-bold mb-2">Nama Barang</label>
            <input type="text" name="name" value="{{ $product->name }}" class="w-full p-3 border rounded-xl" required>
        </div>

        <div class="mb-4">
            <label class="block font-bold mb-2">Harga Jual (Rp)</label>
            <input type="number" name="price" value="{{ $product->price }}" class="w-full p-3 border rounded-xl" required>
        </div>

        <div class="mb-6">
            <label class="block font-bold mb-2">Stok Sekarang</label>
            <input type="number" name="stock" value="{{ $product->stock }}" class="w-full p-3 border rounded-xl" required>
            <p class="text-gray-500 text-xs mt-1">*Ubah angka ini jika ada barang baru masuk.</p>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold w-full">Simpan Perubahan</button>
            <a href="{{ route('products.index') }}" class="bg-gray-200 text-center px-6 py-3 rounded-xl font-bold w-full">Batal</a>
        </div>
    </form>
</div>
@endsection