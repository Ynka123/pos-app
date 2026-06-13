@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-gray-800">Dashboard Kasir</h1>
        <p class="text-gray-500 text-sm">Sistem Kasir Pengelola Transaksi Harian Anda</p>
    </div>

    @livewire('transaction.cart')
@endsection