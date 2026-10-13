<!DOCTYPE html>
<html lang="id" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Rayon Cisarua 7 | SMK Wikrama Bogor</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        gold: {
                            50: '#fefce8',
                            100: '#fef9c3',
                            200: '#fef08a',
                            300: '#fde047',
                            400: '#facc15',
                            500: '#eab308',
                            600: '#ca8a04',
                            700: '#a16207',
                            800: '#854d0e',
                            900: '#713f12',
                        },
                        slate: {
                            850: '#131d31',
                            900: '#0f172a',
                            950: '#020617',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                        display: ['"Space Grotesk"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0b1120;
            color: #e2e8f0;
        }

        /* Custom scrollbars */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #0f172a;
        }

        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #eab308;
        }
    </style>
    @yield('styles')
</head>

<body class="min-h-screen flex flex-col bg-[#0b1120] text-slate-100 antialiased selection:bg-gold-500 selection:text-slate-950">

    <!-- TOP UTILITY BAR (EFEK KUNING DIHAPUS, SIMULASI ROLE POLOS) -->
    <div class="bg-slate-950 border-b border-slate-800 px-4 py-2 text-xs">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <span class="text-slate-300 font-medium">
                    Rayon Cisarua 7
                </span>
                <span class="text-slate-600 hidden sm:inline">|</span>
                <span class="text-slate-400 hidden sm:inline">Tahun Pelajaran 2026/2027</span>
            </div>

            <!-- Tombol Switcher Role (Tanpa Teks "Simulasi Role:") -->
            <div class="flex items-center gap-2">
                <div class="inline-flex rounded-lg p-0.5 bg-slate-800/80 border border-slate-700">
                    <a href="{{ route('quick-login', 'admin') }}"
                        class="px-2.5 py-1 rounded text-[11px] font-semibold transition {{ Auth::check() && Auth::user()->isAdmin() ? 'bg-gold-500 text-slate-950 shadow' : 'text-slate-300 hover:text-gold-300 hover:bg-slate-700/50' }}">
                        Admin
                    </a>
                    <a href="{{ route('quick-login', 'siswa') }}"
                        class="px-2.5 py-1 rounded text-[11px] font-semibold transition {{ Auth::check() && Auth::user()->isSiswa() ? 'bg-gold-500 text-slate-950 shadow' : 'text-slate-300 hover:text-gold-300 hover:bg-slate-700/50' }}">
                        Siswa
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN BRAND HEADER -->
    <header class="bg-slate-900/90 backdrop-blur-md border-b border-slate-800 sticky top-0 z-40 shadow-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Branding & Logo Bulat (Tanpa Bayangan Glow) -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}" class="group flex items-center gap-3.5">
                        <img src="{{ asset('images/logo-c7.jpeg') }}" alt="Logo Cisarua 7" class="w-auto h-10 rounded-full object-cover border border-slate-700">

                        <div>
                            <div class="flex items-center gap-2">
                                <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight font-display text-white">
                                    RAYON CISARUA 7
                                </h1>
                                <span class="hidden md:inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-gold-400 text-slate-950 font-sans shadow-sm">
                                    SMK Wikrama Bogor
                                </span>
                            </div>
                            <p class="text-xs text-slate-400 font-medium tracking-wide">
                                Sistem Informasi, Piket, Transportasi
                            </p>
                        </div>
                    </a>
                </div>

                <!-- User Profile & Action Menu -->
                <div class="flex items-center gap-3">
                    @auth
                    <div class="hidden sm:flex flex-col text-right">
                        <span class="text-xs font-semibold text-slate-200">{{ Auth::user()->name }}</span>
                        <div class="flex items-center justify-end gap-1.5">
                            @if(Auth::user()->isAdmin())
                            <span class="inline-block px-1.5 py-0.2 rounded text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/40"></span>
                            @else
                            <span class="inline-block px-1.5 py-0.2 rounded text-[10px] font-bold bg-sky-500/20 text-sky-300 border border-sky-500/40"></span>
                            @endif
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            title="Keluar"
                            class="p-2.5 rounded-xl bg-slate-800 hover:bg-red-500/20 text-slate-400 hover:text-red-400 border border-slate-700 hover:border-red-500/40 transition">
                            <i class="fa-solid fa-arrow-right-from-bracket text-sm"></i>
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 rounded-xl text-xs font-bold bg-gold-400 text-slate-950 hover:bg-gold-300 transition shadow-md flex items-center gap-1.5">
                        Masuk
                    </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- NAVIGATION TABS (TANPA ICON, TANPA TEKS BERLEBIHAN) -->
        <nav class="bg-slate-950/70 border-t border-slate-800 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto flex items-center space-x-1 sm:space-x-2 overflow-x-auto py-2 scrollbar-none text-xs sm:text-sm font-medium">

                <a href="{{ route('dashboard') }}"
                    class="px-3.5 py-2 rounded-lg transition whitespace-nowrap {{ request()->routeIs('dashboard') ? 'bg-gold-500 text-slate-950 font-bold shadow-md' : 'text-slate-300 hover:text-gold-300 hover:bg-slate-800/80' }}">
                    Dashboard
                </a>

                <a href="{{ route('piket.index') }}"
                    class="px-3.5 py-2 rounded-lg transition whitespace-nowrap {{ request()->routeIs('piket.*') ? 'bg-gold-500 text-slate-950 font-bold shadow-md' : 'text-slate-300 hover:text-gold-300 hover:bg-slate-800/80' }}">
                    Sanksi Piket
                </a>

                <a href="{{ route('pulang.index') }}"
                    class="px-3.5 py-2 rounded-lg transition whitespace-nowrap {{ request()->routeIs('pulang.*') ? 'bg-gold-500 text-slate-950 font-bold shadow-md' : 'text-slate-300 hover:text-gold-300 hover:bg-slate-800/80' }}">
                    Pulang & Angkot
                </a>

                <a href="{{ route('members.index') }}"
                    class="px-3.5 py-2 rounded-lg transition whitespace-nowrap {{ request()->routeIs('members.*') ? 'bg-gold-500 text-slate-950 font-bold shadow-md' : 'text-slate-300 hover:text-gold-300 hover:bg-slate-800/80' }}">
                    Data Anggota
                </a>

                <a href="{{ route('photocopy.index') }}"
                    class="px-3.5 py-2 rounded-lg transition whitespace-nowrap {{ request()->routeIs('photocopy.*') ? 'bg-gold-500 text-slate-950 font-bold shadow-md' : 'text-slate-300 hover:text-gold-300 hover:bg-slate-800/80' }}">
                    Fotokopi Sekitar
                </a>

                <a href="{{ route('bk.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('bk.*') ? 'bg-gold-500/10 text-gold-400 border border-gold-500/20' : 'text-slate-400 hover:text-white' }}">
                    <span>Literasi / Parenting</span>
                </a>

            </div>
        </nav>
    </header>

    <!-- FLASH MESSAGES -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if (session('success'))
        <div x-data="{ show: true }" x-show="show" class="mb-6 flex items-start justify-between p-4 rounded-xl bg-emerald-950/80 border border-slate-700 text-emerald-200 shadow-lg">
            <div class="flex items-center gap-3">
                <div class="h-8 w-8 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-circle-check text-lg"></i>
                </div>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="text-emerald-400 hover:text-emerald-200">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        @endif

        @if (session('error'))
        <div x-data="{ show: true }" x-show="show" class="mb-6 flex items-start justify-between p-4 rounded-xl bg-red-950/80 border border-slate-700 text-red-200 shadow-lg">
            <div class="flex items-center gap-3">
                <div class="h-8 w-8 rounded-lg bg-red-500/20 text-red-400 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                </div>
                <p class="text-sm font-medium">{{ session('error') }}</p>
            </div>
            <button @click="show = false" class="text-red-400 hover:text-red-200">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        @endif

        <!-- PAGE CONTENT -->
        @yield('content')
    </main>

    <!-- FOOTER DENGAN LOGO kustom -->
    <footer class="mt-auto border-t border-slate-800 bg-slate-950 py-6 text-xs text-slate-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-c7.jpeg') }}" alt="Logo Cisarua 7" class="w-8 h-8 rounded-full object-cover">
                <div>
                    <p class="font-semibold text-slate-200">Rayon Cisarua 7 - SMK Wikrama Bogor</p>
                    <p class="text-[11px] text-slate-500">Maju Menuju Kemenangan Bersama Disiplin dan Tanggung Jawab</p>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-4 text-slate-500 text-[11px]">
                <span>Jl. Raya Wangun, Sindangsari, Bogor</span>
                <span>•</span>
                <span>Angkot 02A Biru - Jalur Puncak</span>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>

</html>