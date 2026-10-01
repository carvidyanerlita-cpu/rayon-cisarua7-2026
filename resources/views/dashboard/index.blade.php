@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">

    <!-- HEADER / PENGUMUMAN (SIMPEL TANPA BADGE & ICON) -->
    <div class="card-dark rounded-2xl p-6 border border-slate-800 space-y-2">
        <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight">
            Selamat Datang di Portal Rayon Cisarua 7 SMK Wikrama!
        </h2>
        <p class="text-xs text-slate-400 max-w-4xl leading-relaxed">
            Piket harian wajib dimulai pukul 06:45 WIB sebelum bel masuk berbunyi. Anggota reguler yang alpa tanpa keterangan secara otomatis dikenakan Sanksi Piket 7 Hari Berturut-turut. Selalu pantau polling pulang bareng dan lalu lintas angkot Cisarua.
        </p>
    </div>

    <!-- STATISTIK RINGKASAN (TANPA ICON & BORDER WARNA-WARNI) -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="card-dark rounded-2xl p-4 border border-slate-800 space-y-1">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">TOTAL ANGGOTA</span>
            <div class="text-2xl font-black text-white">45</div>
            <p class="text-[10px] text-slate-500">NIS 12100001 - 12100045</p>
        </div>

        <div class="card-dark rounded-2xl p-4 border border-slate-800 space-y-1">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">AKTIF SEKOLAH</span>
            <div class="text-2xl font-black text-white">36</div>
            <p class="text-[10px] text-slate-500">Jadwal Piket Reguler</p>
        </div>

        <div class="card-dark rounded-2xl p-4 border border-slate-800 space-y-1">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">SEDANG PKL</span>
            <div class="text-2xl font-black text-white">9</div>
            <p class="text-[10px] text-slate-500">Bebas Alpa Piket</p>
        </div>

        <div class="card-dark rounded-2xl p-4 border border-slate-800 space-y-1">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">TINGKAT HADIR</span>
            <div class="text-2xl font-black text-white">73%</div>
            <p class="text-[10px] text-slate-500">Kehadiran Anggota Aktif</p>
        </div>

        <div class="card-dark rounded-2xl p-4 border border-slate-800 space-y-1">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">KENA SANKSI</span>
            <div class="text-2xl font-black text-rose-400">2</div>
            <p class="text-[10px] text-slate-500">Sanksi 7 Hari Aktif</p>
        </div>
    </div>

    <!-- PANEL PENEGAKAN SANKSI PIKET (TANPA ICON) -->
    <div class="card-dark rounded-2xl p-5 border border-slate-800 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-800 pb-3">
            <div>
                <h3 class="text-base font-bold text-white">Panel Peringatan Penegakan Sanksi Piket</h3>
                <p class="text-xs text-slate-400 mt-0.5">Aturan: Siswa reguler yang alpa otomatis dikenakan sanksi piket 7 hari berturut-turut di minggu berikutnya.</p>
            </div>
            <a href="/piket" class="text-xs text-amber-400 font-semibold hover:underline">
                Kelola di Absensi &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300 border-collapse">
                <thead>
                    <tr class="border-b border-slate-800 text-slate-400 bg-slate-900/50">
                        <th class="p-3">NIS</th>
                        <th class="p-3">NAMA ANGGOTA</th>
                        <th class="p-3">JADWAL ASLI</th>
                        <th class="p-3">SANKSI BERLAKU HINGGA</th>
                        <th class="p-3">SISA HUKUMAN</th>
                        <th class="p-3 text-right">AKSI / TINDAKAN</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    <tr>
                        <td class="p-3 font-mono text-slate-400">12100004</td>
                        <td class="p-3 font-bold text-white">Siswa Cisarua 7 #4</td>
                        <td class="p-3"><span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">Senin</span></td>
                        <td class="p-3">02 October 2026</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded bg-rose-500/10 text-rose-400 border border-rose-500/20 text-[11px] font-semibold">
                                3 Hari Tersisa
                            </span>
                        </td>
                        <td class="p-3 text-right">
                            @auth
                                @if(Auth::user()->isAdmin() || (isset(Auth::user()->role) && Auth::user()->role === 'guru_bk'))
                                    <form action="#" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-amber-400 text-slate-950 font-bold rounded-lg hover:bg-amber-300 transition text-xs">
                                            Selesaikan
                                        </button>
                                    </form>
                                @else
                                    <span class="text-slate-500 text-[11px]">Wajib Piket Tiap Hari</span>
                                @endif
                            @endauth
                        </td>
                    </tr>
                    <tr>
                        <td class="p-3 font-mono text-slate-400">12100005</td>
                        <td class="p-3 font-bold text-white">Siswa Cisarua 7 #5</td>
                        <td class="p-3"><span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">Senin</span></td>
                        <td class="p-3">05 October 2026</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded bg-rose-500/10 text-rose-400 border border-rose-500/20 text-[11px] font-semibold">
                                6 Hari Tersisa
                            </span>
                        </td>
                        <td class="p-3 text-right">
                            @auth
                                @if(Auth::user()->isAdmin() || (isset(Auth::user()->role) && Auth::user()->role === 'guru_bk'))
                                    <form action="#" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-amber-400 text-slate-950 font-bold rounded-lg hover:bg-amber-300 transition text-xs">
                                            Selesaikan
                                        </button>
                                    </form>
                                @else
                                    <span class="text-slate-500 text-[11px]">Wajib Piket Tiap Hari</span>
                                @endif
                            @endauth
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- PETUGAS PIKET & ROMBONGAN PULANG (2 KOLOM - TANPA ICON) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- PETUGAS PIKET HARI INI -->
        <div class="lg:col-span-2 card-dark rounded-2xl p-5 border border-slate-800 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                <div>
                    <h3 class="text-base font-bold text-white">Petugas Piket Hari Ini: Rabu</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Total 9 Petugas terjadwal di hari Rabu</p>
                </div>
                <a href="/piket" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-amber-400 text-xs font-semibold border border-slate-700 transition">
                    Isi Kehadiran
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="p-3 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-between">
                    <div>
                        <div class="text-[10px] text-slate-500 font-mono">12100019</div>
                        <div class="text-xs font-bold text-white">Siswa Cisarua 7 #19</div>
                    </div>
                    <span class="text-[10px] font-semibold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20">
                        Hadir
                    </span>
                </div>

                <div class="p-3 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-between">
                    <div>
                        <div class="text-[10px] text-slate-500 font-mono">12100020</div>
                        <div class="text-xs font-bold text-white">Siswa Cisarua 7 #20</div>
                    </div>
                    <span class="text-[10px] font-semibold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20">
                        Hadir
                    </span>
                </div>

                <div class="p-3 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-between">
                    <div>
                        <div class="text-[10px] text-slate-500 font-mono">12100021</div>
                        <div class="text-xs font-bold text-white">Siswa Cisarua 7 #21</div>
                    </div>
                    <span class="text-[10px] font-semibold text-amber-400 bg-amber-500/10 px-2 py-0.5 rounded border border-amber-500/20">
                        Izin
                    </span>
                </div>
            </div>
        </div>

        <!-- ROMBONGAN PULANG BARENG & LALU LINTAS RINGKAS -->
        <div class="card-dark rounded-2xl p-5 border border-slate-800 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                <h3 class="text-base font-bold text-white">Rombongan Pulang Bareng</h3>
                <span class="text-xs text-slate-400">Hari ini</span>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="p-3 rounded-xl bg-slate-900 border border-slate-800 text-center">
                    <div class="text-[10px] text-slate-400 uppercase font-bold">PULANG CEPAT</div>
                    <div class="text-xs font-bold text-white mt-0.5">16:00 WIB</div>
                    <div class="text-sm font-black text-amber-400 mt-1">0 Siswa</div>
                </div>

                <div class="p-3 rounded-xl bg-slate-900 border border-slate-800 text-center">
                    <div class="text-[10px] text-slate-400 uppercase font-bold">EKSTRAKURIKULER</div>
                    <div class="text-xs font-bold text-white mt-0.5">17:30 WIB</div>
                    <div class="text-sm font-black text-amber-400 mt-1">0 Siswa</div>
                </div>
            </div>

            <div class="p-3 rounded-xl bg-slate-900 border border-slate-800 space-y-1">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-white">Lalu Lintas Terkini</span>
                    <span class="text-[10px] text-amber-400 bg-amber-400/10 px-2 py-0.5 rounded border border-amber-400/20 font-bold">Padat</span>
                </div>
                <p class="text-[11px] text-slate-400 leading-relaxed">
                    Info rute: Tajur arah Ciawi padat di sekitar Ramayana Tajur karena antrean angkot ngetem.
                </p>
            </div>

            <a href="/angkot" class="block w-full py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-bold text-xs text-center transition">
                Gabung Rombongan Sekarang
            </a>
        </div>

    </div>

    <!-- PARENTING & FOTOKOPI (2 KOLOM - TANPA ICON) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- PARENTING & BK -->
        <div class="lg:col-span-2 card-dark rounded-2xl p-5 border border-slate-800 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                <div>
                    <h3 class="text-base font-bold text-white">Bimbingan Konseling & Parenting</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Tips belajar, motivasi, dan pendampingan karakter</p>
                </div>
                <a href="/parenting" class="text-xs text-amber-400 font-semibold hover:underline">
                    Semua Artikel & Curhat &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="p-3 rounded-xl bg-slate-900 border border-slate-800 space-y-2">
                    <span class="text-[9px] font-bold text-amber-400 bg-amber-400/10 px-2 py-0.5 rounded border border-amber-400/20">Tips Belajar</span>
                    <h4 class="text-xs font-bold text-white line-clamp-2">Strategi Manajemen Waktu: Keseimbangan Tugas Kejuruan</h4>
                    <p class="text-[10px] text-slate-400 line-clamp-2">Di SMK Wikrama, kedisiplinan dan tanggung jawab adalah nilai utama.</p>
                </div>

                <div class="p-3 rounded-xl bg-slate-900 border border-slate-800 space-y-2">
                    <span class="text-[9px] font-bold text-amber-400 bg-amber-400/10 px-2 py-0.5 rounded border border-amber-400/20">Kesehatan Mental</span>
                    <h4 class="text-xs font-bold text-white line-clamp-2">Mengenali Burnout & Mengatasi Kelelahan Mental</h4>
                    <p class="text-[10px] text-slate-400 line-clamp-2">Tuntutan deadline sertifikasi kejuruan terkadang memicu stres.</p>
                </div>

                <div class="p-3 rounded-xl bg-slate-900 border border-slate-800 space-y-2">
                    <span class="text-[9px] font-bold text-amber-400 bg-amber-400/10 px-2 py-0.5 rounded border border-amber-400/20">Parenting</span>
                    <h4 class="text-xs font-bold text-white line-clamp-2">Panduan Parenting: Komunikasi Positif Orang Tua</h4>
                    <p class="text-[10px] text-slate-400 line-clamp-2">Memasuki masa Praktek Kerja Lapangan (PKL), siswa membutuhkan dukungan.</p>
                </div>
            </div>
        </div>

        <!-- FOTOKOPI SEKITAR -->
        <div class="card-dark rounded-2xl p-5 border border-slate-800 space-y-4 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                    <h3 class="text-base font-bold text-white">Fotokopi & Cetak Tugas</h3>
                    <span class="text-xs text-slate-400">3 Lokasi</span>
                </div>

                <div class="space-y-2 mt-3">
                    <div class="p-2.5 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-between">
                        <div>
                            <div class="text-xs font-bold text-white">Barokah Jaya Wikrama</div>
                            <div class="text-[10px] text-slate-500">150m dari gerbang • Buka 06:00 - 21:00</div>
                        </div>
                        <span class="text-xs font-bold text-amber-400">Rp250/lbr</span>
                    </div>

                    <div class="p-2.5 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-between">
                        <div>
                            <div class="text-xs font-bold text-white">Digital Print Fast Tajur</div>
                            <div class="text-[10px] text-slate-500">400m dari sekolah • Buka 07:00 - 22:00</div>
                        </div>
                        <span class="text-xs font-bold text-amber-400">Rp300/lbr</span>
                    </div>

                    <div class="p-2.5 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-between">
                        <div>
                            <div class="text-xs font-bold text-white">Wikrama Mart Copy Center</div>
                            <div class="text-[10px] text-slate-500">Dalam Kampus • Khusus Pelajar</div>
                        </div>
                        <span class="text-xs font-bold text-amber-400">Rp200/lbr</span>
                    </div>
                </div>
            </div>

            <a href="/fotokopi" class="block w-full py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs text-center border border-slate-700 transition">
                Buka Katalog & Matriks Harga
            </a>
        </div>

    </div>

</div>
@endsection