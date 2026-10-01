@extends('layouts.app')

@section('title', 'Ruang Pulang Bareng & Transportasi Angkot')

@section('content')
<div class="space-y-8">

    <!-- HEADER & TOMBOL AKSI UTAMA -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight">
                Ruang Pulang Bareng & Transportasi Angkot Rayon Cisarua 7
            </h2>
            <p class="text-xs text-slate-400 max-w-2xl mt-1 leading-relaxed">
                Koordinasi rombongan pulang bersama sesama anak Cisarua agar lebih aman, hemat ongkos, dan saling menjaga di perjalanan angkot rute Tajur – Ciawi – Megamendung – Cisarua.
            </p>
        </div>
    
    </div>

    <!-- SEKSI 1: PANDUAN ANGKOT CISARUA -->
    <div class="card-dark rounded-2xl p-6 border border-slate-800 space-y-4">
        <div>
            <h3 class="text-sm font-bold text-white">
                Panduan Angkot Cisarua
            </h3>
            <p class="text-xs text-slate-400 mt-0.5">
                Estimasi ongkos resmi dan tips praktis transportasi siswa SMK Wikrama.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- ANGKOT 02 / 21 -->
            <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800 space-y-2">
                <div class="flex items-center justify-between">
                    <h4 class="text-xs font-bold text-white">Angkot 02 / 21 (Hijau)</h4>
                    <span class="text-[10px] font-bold text-amber-400 bg-amber-400/10 px-2 py-0.5 rounded-md border border-amber-400/20">
                        Rp 4.000 (Pelajar)
                    </span>
                </div>
                <p class="text-[11px] text-slate-300">
                    <strong>Rute:</strong> Tajur (Wikrama) &rightleftharpoons; Ciawi
                </p>
                <p class="text-[10px] text-slate-400">
                    Titik naik di seberang gerbang Wikrama. Estimasi waktu tempuh 5-10 menit tergantung antrean lampu merah Tajur.
                </p>
            </div>

            <!-- ANGKOT 02A -->
            <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800 space-y-2">
                <div class="flex items-center justify-between">
                    <h4 class="text-xs font-bold text-white">Angkot 02A (Biru Cisarua)</h4>
                    <span class="text-[10px] font-bold text-amber-400 bg-amber-400/10 px-2 py-0.5 rounded-md border border-amber-400/20">
                        Rp 5.000 – 10.000
                    </span>
                </div>
                <p class="text-[11px] text-slate-300">
                    <strong>Rute:</strong> Ciawi &rightleftharpoons; Gadog &rightleftharpoons; Cipayung &rightleftharpoons; Pasar Cisarua &rightleftharpoons; Tugu
                </p>
                <p class="text-[10px] text-slate-400">
                    Tarif pelajar hingga Cipayung/Cisarua Rp5.000, hingga Tugu Rp10.000 (dapat disesuaikan).
                </p>
            </div>

            <!-- INFO JADWAL ONE WAY -->
            <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800 space-y-2 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs font-bold text-white">Info Jadwal One Way Puncak</h4>
                        <span class="text-[10px] font-bold text-slate-300 bg-slate-800 px-2 py-0.5 rounded-md">
                            Buka-Tutup Jalur
                        </span>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-2 leading-relaxed">
                        Pantauan lalu lintas & jadwal buka-tutup jalur Puncak secara mandiri via Story Instagram resmi.
                    </p>
                </div>
                
                <a href="https://www.instagram.com/infopuncak.bgr" target="_blank" rel="noopener noreferrer" class="mt-3 inline-flex items-center justify-center gap-1.5 w-full py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-amber-400 text-[11px] font-semibold transition border border-slate-700">
                    Cek Story IG @infopuncak.bgr
                </a>
            </div>
        </div>
    </div>

    <!-- SEKSI 2: ROMBONGAN PULANG -->
    <div id="rombongan" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        
        <!-- ROMBONGAN PULANG CEPAT -->
        <div class="card-dark rounded-2xl p-5 border border-slate-800 space-y-4 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-bold text-white">Rombongan Pulang Cepat</h4>
                        <p class="text-[11px] text-slate-400 mt-0.5">16:00 WIB (Selesai Pembelajaran)</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-800 text-amber-400 border border-slate-700">
                        0 Anggota
                    </span>
                </div>

                <div class="py-8 text-center text-xs text-slate-500">
                    Belum ada siswa yang mendaftar di rombongan 16:00 WIB hari ini.
                </div>
            </div>

            <button class="w-full py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-bold text-xs transition shadow-md">
                Gabung Rombongan 16:00 WIB
            </button>
        </div>

        <!-- ROMBONGAN EKSTRAKURIKULER / SENIBUDAYA -->
        <div class="card-dark rounded-2xl p-5 border border-slate-800 space-y-4 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-bold text-white">Rombongan Ekstrakurikuler/Senibudaya</h4>
                        <p class="text-[11px] text-slate-400 mt-0.5">17:30 WIB (Selesai Ekstrakurikuler / Remidial)</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-800 text-amber-400 border border-slate-700">
                        0 Anggota
                    </span>
                </div>

                <div class="py-8 text-center text-xs text-slate-500">
                    Belum ada siswa yang mendaftar di rombongan 17:30 WIB hari ini.
                </div>
            </div>

            <button class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-amber-400 border border-slate-700 font-bold text-xs transition">
                Gabung Rombongan 17:30 WIB
            </button>
        </div>

    </div>

    <!-- SEKSI 3: PAPAN INFORMASI KEMACETAN (DIBUAT SIMPEL) -->
    <div class="card-dark rounded-2xl p-5 border border-slate-800 space-y-3">
        <div class="flex items-center justify-between border-b border-slate-800 pb-3">
            <h3 class="text-sm font-bold text-white">
                Papan Informasi Kemacetan
            </h3>
            <span class="text-[10px] text-slate-400">Update Realtime Siswa</span>
        </div>

        <p class="text-xs text-slate-400 leading-relaxed">
            Kirim laporan langsung kondisi lalu lintas Jalur Tajur – Ciawi – Cisarua untuk saling membantu teman serayon.
        </p>

        <!-- AREA INPUT SIMPEL -->
        <div class="pt-2">
            <div class="flex gap-2">
                <input type="text" placeholder="Tulis info kondisi jalan (misal: Ciawi macet padat arah Puncak)..." class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-800 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-amber-400/50">
                <button class="px-4 py-2 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 text-xs font-bold transition shrink-0">
                    Kirim
                </button>
            </div>
        </div>
    </div>

</div>
@endsection