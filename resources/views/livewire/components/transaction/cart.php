<?php

namespace App\Livewire\Transaction;

use Livewire\Component;
use App\Models\Product;

class Cart extends Component
{
    public $search = '';
    public $products = [];
    public $cart = [];

    public function mount()
    {
        $this->products = Product::where('stock', '>', 0)->get();
    }

    public function updatedSearch()
    {
        $this->products = Product::where('name', 'like', '%' . $this->search . '%')
            ->where('stock', '>', 0)
            ->get();
    }

    public function render()
    {
        return view('livewire.transaction.cart', [
            'products' => $this->products
        ]);
    }
}