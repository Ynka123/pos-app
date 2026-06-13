<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Kasir</title>
    @vite('resources/css/app.css')
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <button onclick="toggleDarkMode()" class="fixed bottom-5 right-5 bg-slate-800 text-white p-3 rounded-full shadow-lg z-50 hover:scale-110 transition-transform">
        <span id="dark-icon">🌙</span>
    </button>

    <script>
        function toggleDarkMode() {
            const body = document.body;
            const icon = document.getElementById('dark-icon');
            
            // Toggle class 'dark-mode' pada body
            body.classList.toggle('dark-mode');
            
            // Simpan pilihan user ke localStorage biar gak hilang pas refresh
            if (body.classList.contains('dark-mode')) {
                icon.innerText = '☀️';
                localStorage.setItem('theme', 'dark');
            } else {
                icon.innerText = '🌙';
                localStorage.setItem('theme', 'light');
            }
        }

        // Cek tema saat halaman pertama kali dibuka
        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
            document.getElementById('dark-icon').innerText = '☀️';
        }
    </script>

    <style>
        /* Transisi warna halus */
        body { transition: background-color 0.3s, color 0.3s; }

        /* WARNA DARK MODE */
        .dark-mode {
            background-color: #0f172a !important; /* Biru Gelap / Slate 900 */
            color: #f1f5f9;
        }

        /* Kartu Produk & Keranjang jadi gelap */
        .dark-mode .bg-white {
            background-color: #1e293b !important; /* Slate 800 */
            color: white !important;
            border-color: #334155 !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.5);
        }

        /* Input & Search jadi gelap */
        .dark-mode input {
            background-color: #334155 !important;
            color: white !important;
            border-color: #475569 !important;
        }

        /* Sidebar & Area Abu-abu */
        .dark-mode .bg-gray-50, 
        .dark-mode .bg-gray-100,
        .dark-mode .bg-blue-50 {
            background-color: #1e293b !important;
        }

        /* Perbaikan Teks agar tetap kontras */
        .dark-mode .text-gray-800, 
        .dark-mode .text-gray-700,
        .dark-mode .text-gray-600 {
            color: #cbd5e1 !important;
        }
        
        .dark-mode .text-black {
            color: white !important;
        }

        /* Pastikan saat di-hover di dark mode, teks tidak jadi gelap */
        .dark-mode tr:hover td {
            color: white !important;
        }

        /* Biar scrollbar di dark mode gak silau putih */
        .dark-mode::-webkit-scrollbar {
            width: 10px;
            background: #0f172a;
        }
        .dark-mode::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 5px;
        }
    </style>
    <div class="flex min-h-screen">
        <aside class="w-64 bg-gray-900 text-white flex flex-col fixed h-full shadow-2xl">
            <div class="p-6 text-2xl font-black text-center border-b border-gray-800 text-blue-400 tracking-wider uppercase">
                Warung Sejahtera
            </div>
            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('transactions.index') }}" class="flex items-center gap-4 p-3 rounded-xl hover:bg-blue-600 transition group {{ request()->routeIs('transactions.*') ? 'bg-blue-600 shadow-lg' : '' }}">
                    <span class="text-xl">🛒</span> <span class="font-bold">Transaksi Kasir</span>
                </a>
                <a href="{{ route('products.index') }}" class="flex items-center gap-4 p-3 rounded-xl hover:bg-blue-600 transition group {{ request()->routeIs('products.*') ? 'bg-blue-600 shadow-lg' : '' }}">
                    <span class="text-xl">📦</span> <span class="font-bold">Stok Barang</span>
                </a>
                <a href="{{ route('history') }}" wire:navigate class="flex items-center gap-4 p-3 rounded-xl hover:bg-blue-600 transition group {{ request()->routeIs('history') ? 'bg-blue-600 shadow-lg text-white' : 'text-gray-400' }}">
                    <span class="text-xl">📜</span> 
                    <span class="font-bold">Riwayat Pembelian</span>
                </a>
                </a>
            </nav>
            <div class="p-6 border-t border-gray-800 text-xs text-gray-500 text-center italic uppercase tracking-widest">
                Sistem Kasir
            </div>
        </aside>

        <main class="flex-1 ml-64 p-10">
            {{ $slot ?? '' }}
            @yield('content')
        </main>
    </div>

    @livewireScripts
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            window.addEventListener('livewire:initialized', () => {
                @if(session()->has('success'))
                    Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 2000, showConfirmButton: false });
                @endif
                @if(session()->has('error'))
                    Swal.fire({ icon: 'error', title: 'Error!', text: "{{ session('error') }}" });
                @endif
            });
        </script>
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('error', (event) => {
                    // Livewire v3 mengirim data dalam bentuk array/object
                    let pesan = Array.isArray(event) ? event[0] : event;
                    
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian!',
                        text: pesan,
                        timer: 3000
                    });
                });
            });
        </script>
</body>
</html>