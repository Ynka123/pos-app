<?php

namespace App\Livewire\Transaction;

use Livewire\Component;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;

class Cart extends Component
{
    public $search = '';
    public $cart = [];
    public $pay = 0;
    public $change = 0; 

    public function render()
    {
        $products = Product::where('name', 'like', '%' . $this->search . '%')->get();
        $total = $this->calculateTotal();
        
        // Hitung kembalian
        $this->change = max(0, (int)$this->pay - $total);

        return view('livewire.transaction.cart', [
            'products' => $products, // ini biar @foreach di blade gak error
            'total' => $total,
            'change' => $this->change
        ]);
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);
        
        // 1. Cek stok habis (Ini harus tetap memblokir)
        if ($product->stock <= 0) {
            $this->dispatch('error', 'Stok Barang Habis!');
            return; 
        }

        // 2. Peringatan Stok Spesifik (Hanya muncul saat stok PAS di angka 10 atau 5)
        // Pakai == supaya tidak muncul terus-menerus di angka lain
        if ($product->stock == 10 || $product->stock == 5) {
            $this->dispatch('error', 'Peringatan: Stok ' . $product->name . ' sisa ' . $product->stock . ' Pcs lagi!');
        }

        // 3. Proses Transaksi (Tetap lanjut ke bawah, tidak pakai return)
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['qty']++;
        } else {
            $this->cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'qty' => 1,
            ];
        }
    }

    public function increase($id)
    {
        $product = Product::find($id);
        $currentQtyInCart = $this->cart[$id]['qty'];

        if ($currentQtyInCart < $product->stock) {
            $this->cart[$id]['qty']++;
            
            // Cek sisa stok setelah ditambah ke keranjang
            $sisaStok = $product->stock - $this->cart[$id]['qty'];

            // Munculkan alert HANYA jika sisa stok di rak tinggal 10 atau 5
            if ($sisaStok == 10 || $sisaStok == 5) {
                $this->dispatch('error', 'Awas! Sisa stok di gudang tinggal ' . $sisaStok . ' Pcs!');
            }
        } else {
            $this->dispatch('error', 'Stok di gudang sudah habis diambil semua!');
        }
    }

    public function decrease($id)
    {
        if ($this->cart[$id]['qty'] > 1) {
            $this->cart[$id]['qty']--;
        } else {
            unset($this->cart[$id]);
        }
    }

    public function calculateTotal()
    {
        return array_reduce($this->cart, function ($carry, $item) {
            // Kita paksa price dan qty jadi angka (int/float) supaya tidak error saat dikali
            return $carry + ((float)$item['price'] * (int)$item['qty']);
        }, 0);
    }

    public function saveTransaction($withPrint = false)
    {
        $total = $this->calculateTotal();
        // Pastikan total dihitung ulang sebelum dicek
    
        // Paksa variabel pay jadi angka, buat jaga-jaga kalau terbaca string
        $bayar = (int)$this->pay;

        if ($bayar < $total) {
            $this->dispatch('error', 'Uang Kurang! Totalnya Rp ' . number_format($total));
            return;
        }
            
        if ($total <= 0) {
            $this->dispatch('error', 'Keranjang masih kosong!');
            return;
        }
        
        // Validasi uang bayar
        if ((int)$this->pay < $total) {
            $this->dispatch('error', 'Uangnya kurang woi!, Kurang Rp ' . number_format($total - (int)$this->pay)); 
            return;
        }

        DB::transaction(function () use ($total, $withPrint) {
            $transaction = Transaction::create([
                'invoice' => 'INV-' . time(),
                'total' => $total,
                'discount' => 0,
                'pay' => $this->pay,
                'change' => $this->change,
            ]);

            foreach ($this->cart as $id => $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $id,
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['qty'],
                ]);

                // Kurangi stok barang di database
                Product::find($id)->decrement('stock', $item['qty']);
            }

            // Jika tombol 'Simpan & Cetak' diklik
            if ($withPrint) {
                $this->dispatch('print-receipt', ['transactionId' => $transaction->id]);
            }
        });

        // Kirim sinyal sukses ke SweetAlert di browser
        $this->dispatch('success', 'Makasih udah berbelanja!');

        // Reset semua data di halaman kasir
        $this->reset(['cart', 'pay', 'change']);
        session()->flash('success', 'Data berhasil dicatat!');
    }

    public function restockSemua()
    {
        Product::query()->update(['stock' => 1000]); 
        
        $this->dispatch('success', 'Semua stok berhasil diisi!');
    }

    public function updateQty($id, $newQty)
    {
        $product = Product::find($id);
        
        // Paksa jadi integer agar tidak dianggap teks
        $newQty = (int)$newQty;

        if ($newQty < 1) {
            $this->cart[$id]['qty'] = 1;
            $this->dispatch('error', 'Minimal pembelian 1 unit!');
            return;
        }

        if ($newQty > $product->stock) {
            $this->cart[$id]['qty'] = $product->stock;
            $this->dispatch('error', 'Stok terbatas! Maksimal: ' . $product->stock);
            return;
        }

        $this->cart[$id]['qty'] = $newQty;
    }
    public function clearCart()
    {
        // Kosongkan array cart
        $this->cart = [];
        
        // Reset uang bayar jadi 0 juga biar sinkron
        $this->pay = 0;

        // Kirim notifikasi sukses
        $this->dispatch('success', 'Keranjang berhasil dikosongkan!');
    }
}