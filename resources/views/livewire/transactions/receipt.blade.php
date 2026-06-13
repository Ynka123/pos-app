<!DOCTYPE html>
<html>
<head>
    <title>Struk #{{ $transaction->invoice }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; width: 300px; padding: 20px; }
        .text-center { text-align: center; }
        .line { border-bottom: 1px dashed #000; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; }
        .total { font-weight: bold; font-size: 1.2em; }
    </style>
</head>
<body onload="window.print();">
    <div class="text-center">
        <h3>WARUNG SEJAHTERA</h3>
        <p>{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
        <p>Invoice: {{ $transaction->invoice }}</p>
    </div>
    <div class="line"></div>
    <table>
        @foreach($transaction->details as $item)
        <tr>
            <td>{{ $item->product->name }} x {{ $item->qty }}</td>
            <td align="right">{{ number_format($item->subtotal) }}</td>
        </tr>
        @endforeach
    </table>
    <div class="line"></div>
    <table>
        <tr>
            <td>Total</td>
            <td align="right" class="total">Rp {{ number_format($transaction->total) }}</td>
        </tr>
        <tr>
            <td>Bayar</td>
            <td align="right">Rp {{ number_format($transaction->pay) }}</td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td align="right">Rp {{ number_format($transaction->change) }}</td>
        </tr>
    </table>
    <div class="line"></div>
    <p class="text-center italic">Terima Kasih Sudah Berbelanja!</p>
</body>
</html>