<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class HistoryController extends Controller
{
    public function index()
    {
        // Ambil data transaksi terbaru beserta detailnya
        $history = Transaction::with('details.product')->latest()->get();
        
        return view('history.index', compact('history'));
    }
}