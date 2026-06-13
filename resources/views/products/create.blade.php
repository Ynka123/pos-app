@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Tambah Produk Baru</h1>
        <a href="{{ route('products.index') }}" class="text-blue-600 text-sm">← Kembali ke daftar</a>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
        <form action="{{ route('products.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Nama Barang</label>
                <input type="text" name="name" class="w-full p-3 border-2 border-gray-100 rounded-xl focus:border-blue-500 outline-none" placeholder="Contoh: Makaroni" required>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Harga (Rp)</label>
                    <input type="number" name="price" class="w-full p-3 border-2 border-gray-100 rounded-xl focus:border-blue-500 outline-none" placeholder="Contoh: 5000" required>
                </div>
                <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Jumlah Stok Awal</label>
                <input type="number" name="stock" class="w-full p-3 border rounded-xl" placeholder="Contoh: 100" required>
                </div>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-xl font-black text-lg shadow-lg hover:bg-blue-700 transition">
                SIMPAN PRODUK
            </button>
        </form>
    </div>
</div>
@endsection