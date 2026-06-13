<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    // Ini fungsi buat nampilin halaman kasir yang tadinya ilang
    public function index()
    {
        return view('transactions.index');
    }

    // Ini fungsi buat nampilin struk belanja
    public function print($id)
    {
        $transaction = Transaction::with('details.product')->findOrFail($id);
        return view('transactions.receipt', compact('transaction'));
    }
}