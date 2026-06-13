@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Gudang Barang</h1>
        <p class="text-gray-500 text-sm">Kelola nama, harga, dan stok barang secara real-time.</p>
    </div>
    <a href="{{ route('products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl font-bold shadow-lg transition">
        + Tambah Barang Baru
    </a>
</div>

<div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">
    <table class="w-full text-left">
        <thead class="bg-gray-800 text-white">
            <tr>
                <th class="p-4 text-xs font-bold uppercase tracking-wider">Nama Produk</th>
                <th class="p-4 text-xs font-bold uppercase tracking-wider text-center">Harga Jual</th>
                <th class="p-4 text-xs font-bold uppercase tracking-wider text-center">Stok Tersedia</th>
                <th class="p-4 text-xs font-bold uppercase tracking-wider text-center">Edit atau Hapus</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($products as $p)
            <tr class="hover:bg-gray-50 transition">
                <td class="p-4">
                    <p class="font-bold text-gray-800">{{ $p->name }}</p>
                </td>
                <td class="p-4 text-center font-bold text-blue-600">
                    Rp {{ number_format($p->price) }}
                </td>
                <td class="p-4 text-center">
                    <span class="px-4 py-1 rounded-full font-black {{ $p->stock <= 10 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                        {{ $p->stock }} Pcs
                    </span>
                </td>
                <td class="p-4">
                    <div class="flex items-center justify-center gap-4">
                        <a href="{{ route('products.edit', $p->id) }}" class="text-blue-600 hover:text-blue-800 font-bold text-sm flex items-center gap-1">
                            <span>✏️</span> Edit
                        </a>

                        <form action="{{ route('products.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus barang dari toko?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm flex items-center gap-1">
                                <span>🗑️</span> Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection