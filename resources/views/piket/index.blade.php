@extends('layouts.app')

@section('title', 'Absensi Piket & Sanksi Otomatis')

@section('content')
<div class="space-y-6">

    <!-- HEADER & STATUS COUNTER -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight">
                Absensi Piket & Sanksi Otomatis 7 Hari
            </h2>
            <p class="text-xs text-slate-400 max-w-2xl mt-1 leading-relaxed">
                Pengurus rayon mengelola kehadiran piket harian. Siswa reguler yang berstatus Alpa akan otomatis dijatuhi Sanksi Piket 7 Hari Berturut-turut. Anggota berstatus PKL dikunci sistem dan bebas alpa.
            </p>
        </div>

        <!-- BADGE STATUS TANPA ICON -->
        <div class="flex flex-wrap items-center gap-2 shrink-0">
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                0 Hadir
            </span>
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                0 Izin
            </span>
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-purple-500/10 text-purple-400 border border-purple-500/20">
                0 Sakit
            </span>
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-rose-500/10 text-rose-400 border border-rose-500/20">
                0 Alpa (Sanksi)
            </span>
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-sky-500/10 text-sky-400 border border-sky-500/20">
                0 Sedang PKL
            </span>
        </div>
    </div>

    <!-- FILTER & TANGGAL -->
    <div class="card-dark rounded-2xl p-4 border border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex items-center gap-2">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">PILIH TANGGAL:</label>
                <input type="date" value="{{ date('Y-m-d') }}" class="px-3 py-1.5 rounded-xl bg-slate-900 border border-slate-800 text-xs text-white focus:outline-none focus:border-slate-700">
            </div>

            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">FILTER HARI PIKET:</span>
                <div class="flex items-center bg-slate-900 p-1 rounded-xl border border-slate-800 text-xs">
                    <button class="px-3 py-1 rounded-lg bg-amber-400 text-slate-950 font-bold">Semua</button>
                    <button class="px-3 py-1 rounded-lg text-slate-400 hover:text-white transition">Senin</button>
                    <button class="px-3 py-1 rounded-lg text-slate-400 hover:text-white transition">Selasa</button>
                    <button class="px-3 py-1 rounded-lg text-slate-400 hover:text-white transition">Rabu</button>
                    <button class="px-3 py-1 rounded-lg text-slate-400 hover:text-white transition">Kamis</button>
                    <button class="px-3 py-1 rounded-lg text-slate-400 hover:text-white transition">Jumat</button>
                </div>
            </div>
        </div>

        <!-- HANYA MENAMPILKAN REFRESH DAN KETERANGAN 45 SISWA -->
        <div class="flex items-center gap-3 self-end md:self-auto">
            <span class="text-xs text-slate-400 font-medium">Menampilkan 45 Siswa</span>
            <button class="p-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-slate-400 hover:text-white border border-slate-800 transition" title="Refresh Data">
                Refresh
            </button>
        </div>
    </div>

    <!-- KONTEN UTAMA: TABEL PIKET & WHATSAPP GENERATOR -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- TABEL DAFTAR ANGGOTA (2 KOLOM DI DESKTOP) -->
        <div class="lg:col-span-2 card-dark rounded-2xl p-5 border border-slate-800 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                <div>
                    <h3 class="text-base font-bold text-white">Daftar Anggota Rayon Cisarua 7</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Jadwal Tanggal: {{ date('d F Y') }}</p>
                </div>
                <span class="text-[11px] font-medium text-sky-400 bg-sky-500/10 px-2.5 py-1 rounded-lg border border-sky-500/20">
                    Terkunci PKL (9 Siswa)
                </span>
            </div>

            <!-- TABEL ANGGOTA LENGKAP 45 SISWA -->
            <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
                <table class="w-full text-left text-xs text-slate-300 border-collapse">
                    <thead class="sticky top-0 bg-slate-900 z-10">
                        <tr class="border-b border-slate-800 text-slate-400">
                            <th class="p-3">NIS</th>
                            <th class="p-3">NAMA ANGGOTA</th>
                            <th class="p-3">HARI</th>
                            <th class="p-3">STATUS PIKET</th>
                            <th class="p-3">CATATAN</th>
                            <th class="p-3 text-center">SIMPAN</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60">
                        @php
                            $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                        @endphp
                        @for ($i = 1; $i <= 45; $i++)
                            @php
                                $hari = $hariList[($i - 1) % 5];
                                $nis = 12100000 +$i;
                            @endphp
                            <tr>
                                <td class="p-3 font-mono text-slate-400">{{ $nis }}</td>
                                <td class="p-3 font-bold text-white">
                                    Siswa Cisarua 7 #{{ $i }}
                                    @if($i == 4)
                                        <span class="ml-1 text-[9px] bg-rose-500/20 text-rose-400 border border-rose-500/30 px-1.5 py-0.5 rounded font-semibold">SANKSI</span>
                                        <div class="text-[10px] text-rose-400 font-normal">Sanksi s/d 02 Oct 2026 (3 hari lagi)</div>
                                    @elseif($i == 5)
                                        <span class="ml-1 text-[9px] bg-rose-500/20 text-rose-400 border border-rose-500/30 px-1.5 py-0.5 rounded font-semibold">SANKSI</span>
                                        <div class="text-[10px] text-rose-400 font-normal">Sanksi s/d 05 Oct 2026 (6 hari lagi)</div>
                                    @endif
                                </td>
                                <td class="p-3"><span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">{{ $hari }}</span></td>
                                <td class="p-3">
                                    <select class="bg-slate-900 border border-slate-800 text-emerald-400 rounded-lg px-2 py-1 text-xs focus:outline-none">
                                        <option>Hadir</option>
                                        <option>Izin</option>
                                        <option>Sakit</option>
                                        <option>Alpa</option>
                                    </select>
                                </td>
                                <td class="p-3"><input type="text" placeholder="Keterangan dispensasi" class="bg-slate-900 border border-slate-800 rounded-lg px-2.5 py-1 text-xs text-white w-full"></td>
                                <td class="p-3 text-center">
                                    <button class="px-3 py-1 bg-amber-400 text-slate-950 font-bold rounded-lg hover:bg-amber-300 transition">Simpan</button>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>

        <!-- WHATSAPP GENERATOR (KOLOM KANAN) -->
        <div class="card-dark rounded-2xl p-5 border border-slate-800 space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                    <div>
                        <h3 class="text-base font-bold text-white">WhatsApp Generator</h3>
                        <p class="text-[11px] text-slate-400">Format Laporan Otomatis Rayon</p>
                    </div>
                </div>

                <!-- PREVIEW FORMAT DENGAN FONT SAMA DENGAN WEB -->
                <div class="p-4 rounded-xl bg-slate-900 border border-slate-800 text-xs text-slate-300 font-sans leading-relaxed space-y-2 whitespace-pre-line select-all">
*LAPORAN PIKET HARIAN RAYON CISARUA 7*
*SMK WIKRAMA BOGOR*
Tanggal: {{ date('l, d F Y') }}

*HADIR (0 Siswa)*:
- NIHIL

*IZIN (0 Siswa)*:
- NIHIL

*SAKIT (0 Siswa)*:
- NIHIL

*ALPA / SANKSI 7 HARI (0 Siswa)*:
- NIHIL

*SEDANG PKL (0 Siswa)*:
- NIHIL
                </div>
            </div>

            <!-- TOMBOL AKSES -->
            <div class="pt-2 grid grid-cols-2 gap-2">
                <button onclick="copyToClipboard()" class="w-full py-2.5 px-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs transition border border-slate-700">
                    Salin Teks Laporan
                </button>
            </div>
        </div>

    </div>

</div>

<script>
    function copyToClipboard() {
        const textToCopy = `*LAPORAN PIKET HARIAN RAYON CISARUA 7*\n*SMK WIKRAMA BOGOR*\nTanggal: {{ date('l, d F Y') }}\n\n*HADIR (0 Siswa)*:\n- NIHIL\n\n*IZIN (0 Siswa)*:\n- NIHIL\n\n*SAKIT (0 Siswa)*:\n- NIHIL\n\n*ALPA / SANKSI 7 HARI (0 Siswa)*:\n- NIHIL\n\n*SEDANG PKL (0 Siswa)*:\n- NIHIL`;
        navigator.clipboard.writeText(textToCopy).then(() => {
            alert('Teks laporan berhasil disalin!');
        });
    }
</script>
@endsection