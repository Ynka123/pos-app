@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Riwayat Penjualan</h1>
    <p class="text-gray-500">Daftar transaksi yang berhasil diproses.</p>
</div>

<div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-800 text-white">
            <tr>
                <th class="p-4 uppercase text-xs font-bold">Waktu</th>
                <th class="p-4 uppercase text-xs font-bold">Invoice</th>
                <th class="p-4 uppercase text-xs font-bold">Total Belanja</th>
                <th class="p-4 uppercase text-xs font-bold">Detail Barang</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($history as $trx)
            <tr class="hover:bg-gray-50 transition">
            <td class="p-4 text-center">
                <a href="{{ route('print.receipt', $trx->id) }}" target="_blank" class="bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded text-xs font-bold">
                    🖨️ Cetak Struk
                </a>
            </td>
                <td class="p-4 text-sm text-gray-600">{{ $trx->created_at->format('d M Y, H:i') }}</td>
                <td class="p-4 font-mono font-bold text-blue-600">{{ $trx->invoice }}</td>
                <td class="p-4 font-bold text-gray-800">Rp {{ number_format($trx->total) }}</td>
                <td class="p-4">
                    <ul class="text-xs text-gray-500 space-y-1">
                        @foreach($trx->details as $detail)
                        <li>• {{ $detail->product->name ?? 'Produk Dihapus' }} ({{ $detail->qty }} pcs)</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="p-10 text-center text-gray-400 italic">Belum ada riwayat transaksi hari ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection