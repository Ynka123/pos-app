<!DOCTYPE html>
<html>
<head>
    <title>Struk_{{ $transaction->invoice }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; width: 80mm; margin: 0; padding: 10px; }
        .text-center { text-align: center; }
        .line { border-bottom: 1px dashed #000; margin: 10px 0; }
        table { width: 100%; font-size: 12px; }
        .total { font-weight: bold; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">
    <div class="text-center">
        <h3 style="margin:0">WARUNG SEJAHTERA</h3>
        <p style="font-size:10px">Jl. Raya Ekonomi No. 1, Indonesia</p>
    </div>
    
    <div class="line"></div>
    <table border="0">
        <tr><td>No: {{ $transaction->invoice }}</td></tr>
        <tr><td>Tgl: {{ $transaction->created_at->format('d/m/y H:i') }}</td></tr>
    </table>
    <div class="line"></div>

    <table>
        @foreach($transaction->details as $item)
        <tr>
            <td colspan="2">{{ $item->product->name }}</td>
        </tr>
        <tr>
            <td>{{ $item->qty }} x {{ number_format($item->price) }}</td>
            <td style="text-align:right">{{ number_format($item->qty * $item->price) }}</td>
        </tr>
        @endforeach
    </table>

    <div class="line"></div>
    <table>
        <tr><td>TOTAL</td><td style="text-align:right">{{ number_format($transaction->total) }}</td></tr>
        <tr><td>BAYAR</td><td style="text-align:right">{{ number_format($transaction->pay) }}</td></tr>
        <tr><td>KEMBALI</td><td style="text-align:right">{{ number_format($transaction->change) }}</td></tr>
    </table>
    <div class="line"></div>
    <p class="text-center" style="font-size:10px">Terima Kasih Atas Kunjungan Anda!</p>
    
    <button class="no-print" onclick="window.history.back()">Kembali</button>
</body>
</html>