<?php

namespace App\Livewire\Transaction;

use Livewire\Component;
use App\Models\Transaction;
use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithPagination;

class History extends Component
{
    use WithPagination;

    public function exportExcel()
    {
        // Fungsi untuk download file excel
        return Excel::download(new TransactionsExport, 'laporan-warung-' . date('d-m-Y') . '.xlsx');
    }

    public function render()
    {
        return view('livewire.transaction.history', [
            // Jangan all(), pakai paginate supaya cuma ambil 10 data per halaman
            'transactions' => Transaction::latest()->paginate(10)
        ]);
    }
}