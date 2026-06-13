<div> {{-- Harus dibungkus satu div utama --}}
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-4">Riwayat Pembelian</h2>
        
        {{-- Tombol Export --}}
        <button wire:click="exportExcel" class="bg-green-600 text-white px-4 py-2 rounded-lg mb-4">
            📊 Export Excel
        </button>

        {{-- Tabel --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-slate-700">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-slate-700 text-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="p-4 border-b dark:border-slate-600">Invoice</th>
                        <th class="p-4 border-b dark:border-slate-600">Total</th>
                        <th class="p-4 border-b dark:border-slate-600">Tanggal</th>
                        <th class="p-4 border-b dark:border-slate-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    @foreach($transactions as $trx)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors group">
                        <td class="p-4 font-mono text-blue-600 dark:text-blue-400 font-semibold">
                            {{ $trx->invoice }}
                        </td>
                        <td class="p-4 font-bold text-gray-900 dark:text-white">
                            Rp {{ number_format($trx->total) }}
                        </td>
                        <td class="p-4 text-gray-600 dark:text-gray-300">
                            {{ $trx->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="p-4 text-center">
                            <a href="{{ route('print.receipt', $trx->id) }}" target="_blank" 
                            class="inline-flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded-lg text-xs font-bold transition shadow-md active:scale-95">
                            🖨️ Cetak
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>