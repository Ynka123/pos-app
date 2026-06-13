<div>
    <div class="grid grid-cols-12 gap-6 p-4">
        <div class="col-span-12 lg:col-span-8">
            <div class="mb-4">
                <input type="text" wire:model.live.debounce.500ms="search" placeholder="Cari nama barang..." class="w-full p-3 border rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($products as $product)
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
                    <h3 class="font-bold text-lg text-gray-800">{{ $product->name }}</h3>
                    <p class="text-blue-600 font-bold text-xl">Rp {{ number_format($product->price) }}</p>
                    <p class="text-xs mb-4 {{ $product->stock <= 10 ? 'text-red-600 font-bold' : 'text-gray-400' }}">
                        Stok: {{ $product->stock }} Pcs
                    </p>
                    <button wire:click="addToCart({{ $product->id }})" 
                        class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg font-bold transition">
                        + Pilih
                    </button>
                </div>
                @endforeach
            </div>
        </div>

        <div class="col-span-12 lg:col-span-4">
            <div class="bg-white p-6 rounded-2xl shadow-xl sticky top-4 border border-gray-100">
                
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <h2 class="font-bold text-xl text-gray-800">Keranjang Belanja</h2>
                    <button wire:click="clearCart" onclick="confirm('Yakin mau kosongkan keranjang?') || event.stopImmediatePropagation()" 
                        class="bg-red-500 hover:bg-red-600 text-white text-[10px] px-2 py-1 rounded shadow-sm uppercase font-bold transition">
                        Clear All
                    </button>
                </div>

                <div class="space-y-4 mb-6 max-h-96 overflow-y-auto pr-2">
                    @forelse($cart as $id => $item)
                    <div class="flex justify-between items-center bg-gray-50 p-3 rounded-xl border-l-4 border-blue-500">
                        <div class="flex-1">
                            <p class="font-bold text-sm text-gray-800">{{ $item['name'] }}</p>
                            <p class="text-xs text-gray-500">Rp {{ number_format($item['price']) }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button wire:click="decrease('{{ $id }}')" class="bg-gray-200 hover:bg-gray-300 px-2 rounded-lg font-bold">-</button>
                            <input type="number" 
                                wire:model.live.debounce.500ms="cart.{{ $id }}.qty" 
                                wire:change="updateQty('{{ $id }}', $event.target.value)"
                                class="w-10 text-center bg-transparent border-b-2 border-gray-300 focus:border-blue-500 outline-none font-bold text-sm">
                            <button wire:click="increase('{{ $id }}')" class="bg-gray-200 hover:bg-gray-300 px-2 rounded-lg font-bold">+</button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10">
                        <p class="text-gray-400 italic">Keranjang masih kosong</p>
                    </div>
                    @endforelse
                </div>

                <div class="border-t pt-4 space-y-2">
                    <div class="flex justify-between text-gray-600 text-sm">
                        <span>Subtotal:</span>
                        <span>Rp {{ number_format($this->calculateTotal()) }}</span>
                    </div>
                    @if(isset($discount) && $discount > 0)
                    <div class="flex justify-between text-red-500 text-sm">
                        <span>Diskon:</span>
                        <span>-Rp {{ number_format($discount) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-2xl font-black text-gray-900 pt-2 border-t">
                        <span>Total:</span>
                        <span>Rp {{ number_format($this->calculateTotal()) }}</span>
                    </div>

                    <div class="mt-6 bg-blue-50 p-4 rounded-xl border border-blue-100">
                        <label class="block text-[10px] font-bold text-blue-500 mb-1 uppercase tracking-wider">Masukkan Uang Bayar:</label>
                        <input type="number" 
                            wire:model.live="pay" 
                            wire:keydown.enter.prevent="saveTransaction"
                            placeholder="0"
                            class="w-full text-2xl font-bold bg-transparent border-b-2 border-blue-400 outline-none focus:border-blue-600 transition">
                        
                            <div class="mt-3 flex justify-between text-lg">
                                <span class="text-gray-700">Uang Kembali:</span>
                                <span class="text-blue-600 font-bold">Rp {{ number_format($change) }}</span>
                            </div>

                    <div class="grid grid-cols-2 gap-3 mt-6">
                    <button wire:click="saveTransaction(false)" 
                            class="bg-gray-700 hover:bg-gray-800 text-white py-3 rounded-xl font-bold text-xs shadow-lg transition uppercase">
                            Simpan </button>

                        <button wire:click="saveTransaction(true)" 
                                class="bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-bold text-xs shadow-lg shadow-blue-200 transition uppercase">
                            Simpan & Cetak
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('livewire:init', () => {
        // Pop-up Error/Peringatan
        Livewire.on('error', (message) => {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: message[0],
                confirmButtonColor: '#ef4444'
            });
        });
    
        // Pop-up Berhasil
        Livewire.on('success', (message) => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: message[0],
                timer: 2000,
                showConfirmButton: false
            });
        });

        // Event Cetak Struk
        window.addEventListener('print-receipt', event => {
            const id = event.detail[0].transactionId;
            const printWindow = window.open('/print-receipt/' + id, '_blank', 'width=400,height=600');
            printWindow.focus();
        });
    });
</script>