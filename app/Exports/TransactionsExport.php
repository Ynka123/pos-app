<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Ambil semua data transaksi
        return Transaction::all();
    }

    // Mengatur judul kolom di Excel
    public function headings(): array
    {
        return [
            'ID Transaksi',
            'No. Invoice',
            'Total Belanja',
            'Uang Bayar',
            'Kembalian',
            'Tanggal Transaksi',
        ];
    }

    // Mengatur data mana saja yang masuk ke kolom
    public function map($transaction): array
    {
        return [
            $transaction->id,
            $transaction->invoice,
            $transaction->total,
            $transaction->pay,
            $transaction->change,
            $transaction->created_at->format('d-m-Y H:i'),
        ];
    }
}