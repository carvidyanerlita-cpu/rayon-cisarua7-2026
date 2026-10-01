@extends('layouts.app')

@section('title', 'Lokasi Fotokopi & Percetakan Sekitar')

@section('content')
<div class="space-y-8">

    <!-- HEADER -->
    <div>
        <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight">
            Rekomendasi Tempat Fotokopi & Percetakan
        </h2>
        <p class="text-xs text-slate-400 max-w-2xl mt-0.5">
            Daftar lokasi fotokopi, print, dan cetak dokumen terdekat di sekitar Tajur, Wangun, hingga jalur Puncak untuk kebutuhan tugas siswa.
        </p>
    </div>

    <!-- SEKSI 1: FASILITAS INTERNAL SEKOLAH -->
    <div class="space-y-3">
        <h3 class="text-sm font-bold text-amber-400 uppercase tracking-wider">
            INTERNAL SEKOLAH
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- KOPERASI MAS DEN -->
            <div class="card-dark rounded-2xl p-5 border border-amber-500/20 shadow-xl space-y-3 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <h4 class="text-base font-bold text-white">Koperasi Mas Den</h4>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                            Buka Jam Sekolah
                        </span>
                    </div>
                    <p class="text-[11px] text-amber-300 font-medium mt-0.5">
                        Area Dalam SMK Wikrama Bogor
                    </p>
                    
                    <div class="mt-3 p-3 rounded-xl bg-slate-900/80 border border-slate-800 text-xs text-slate-300 space-y-1.5">
                        <p><strong>Jam Operasional:</strong> 06.45 – 16.30 WIB</p>
                        <p><strong>Layanan:</strong> Fotokopi dokumen, cetak tugas sekolah, pembelian kertas folio, dan ATK harian siswa.</p>
                        <p><strong>Kisaran Harga:</strong> Tarif terjangkau ramah kantong pelajar (Khusus Siswa).</p>
                    </div>
                </div>

                <a href="https://maps.google.com" target="_blank" class="inline-flex items-center justify-center gap-2 w-full py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-amber-400 border border-amber-500/30 text-xs font-semibold transition">
                    Petunjuk Google Maps
                </a>
            </div>
        </div>
    </div>

    <!-- SEKSI 2: LOKASI AREA TAJUR & WANGUN -->
    <div class="space-y-3">
        <h3 class="text-sm font-bold text-amber-400 uppercase tracking-wider">
            AREA TAJUR & WANGUN (DEKAT RUTE SEKOLAH)
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- KIA ATK -->
            <div class="card-dark rounded-2xl p-5 border border-slate-800 space-y-3 flex flex-col justify-between">
                <div>
                    <h4 class="text-sm font-bold text-white">KIA ATK - Fotocopy - Printing</h4>
                    <p class="text-[11px] text-slate-400 mt-1 leading-relaxed">
                        Jl. Raya Tajur, Wangun Lebaksari No.12, RT.02/RW.06, Sindangsari, Bogor Timur.
                    </p>
                    <div class="mt-3 p-2.5 rounded-xl bg-slate-900/60 border border-slate-800/80 text-xs text-slate-300 space-y-1">
                        <p>Terletak di koridor utama dekat area Wangun & rute SMK Wikrama.</p>
                        <p>Menyediakan fotokopi dokumen & ATK standar.</p>
                    </div>
                </div>

                <a href="https://maps.google.com" target="_blank" class="inline-flex items-center justify-center gap-2 w-full py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-amber-400 border border-slate-800 text-xs font-semibold transition">
                    Petunjuk Google Maps
                </a>
            </div>

            <!-- DIGITAL PRINT FAST TAJUR -->
            <div class="card-dark rounded-2xl p-5 border border-slate-800 space-y-3 flex flex-col justify-between">
                <div>
                    <h4 class="text-sm font-bold text-white">Digital Print Fast Tajur</h4>
                    <p class="text-[11px] text-slate-400 mt-1 leading-relaxed">
                        Area Jalan Raya Tajur, Bogor Timur.
                    </p>
                    <div class="mt-3 p-2.5 rounded-xl bg-slate-900/60 border border-slate-800/80 text-xs text-slate-300 space-y-1">
                        <p><strong>Jam Operasional:</strong> 07.00 – 22.00 WIB</p>
                        <p>Cetak cepat, jilid mika/hardcover, hingga print A3.</p>
                    </div>
                </div>

                <a href="https://maps.google.com" target="_blank" class="inline-flex items-center justify-center gap-2 w-full py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-amber-400 border border-slate-800 text-xs font-semibold transition">
                    Petunjuk Google Maps
                </a>
            </div>
        </div>
    </div>

    <!-- SEKSI 3: REKOMENDASI LOKASI AREA PUNCAK & SEKITARNYA -->
    <div class="space-y-3">
        <h3 class="text-sm font-bold text-amber-400 uppercase tracking-wider">
            AREA PUNCAK, MEGAMENDUNG & CISARUA
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            
            <!-- PASUNDAN FOTOCOPY -->
            <div class="card-dark rounded-2xl p-5 border border-slate-800 space-y-3 flex flex-col justify-between">
                <div>
                    <h4 class="text-sm font-bold text-white">PASUNDAN FOTOCOPY & PRINT A3+</h4>
                    <p class="text-[11px] text-slate-400 mt-1">Jl. Raya Puncak - Cianjur No.29, Cipayung Girang, Megamendung.</p>
                    <div class="mt-3 p-2.5 rounded-xl bg-slate-900/60 border border-slate-800 text-xs text-slate-300 space-y-1">
                        <p>07.00 – 21.00 WIB</p>
                        <p>Fotokopi, ATK, jilid, kartu BPJS/NPWP, hingga print A3+.</p>
                        <p class="text-emerald-400">+62 851-8300-5541</p>
                    </div>
                </div>
                <a href="https://maps.google.com" target="_blank" class="inline-flex items-center justify-center gap-2 w-full py-2 rounded-xl bg-slate-900 text-amber-400 border border-slate-800 text-xs font-semibold transition">
                    Petunjuk Google Maps
                </a>
            </div>

            <!-- SAFARICREW -->
            <div class="card-dark rounded-2xl p-5 border border-slate-800 space-y-3 flex flex-col justify-between">
                <div>
                    <h4 class="text-sm font-bold text-white">SafariCrew Digital Foto copy</h4>
                    <p class="text-[11px] text-slate-400 mt-1">Jl. Raya Puncak - Cianjur No.01, Leuwimalang, Cisarua.</p>
                    <div class="mt-3 p-2.5 rounded-xl bg-slate-900/60 border border-slate-800 text-xs text-slate-300 space-y-1">
                        <p>07.00 – 21.00 WIB</p>
                        <p>Pas foto kilat, cetak warna, jilid hard cover.</p>
                        <p class="text-emerald-400">+62 812-9115-4535</p>
                    </div>
                </div>
                <a href="https://maps.google.com" target="_blank" class="inline-flex items-center justify-center gap-2 w-full py-2 rounded-xl bg-slate-900 text-amber-400 border border-slate-800 text-xs font-semibold transition">
                    Petunjuk Google Maps
                </a>
            </div>

            <!-- BINTANG PRINT -->
            <div class="card-dark rounded-2xl p-5 border border-slate-800 space-y-3 flex flex-col justify-between">
                <div>
                    <h4 class="text-sm font-bold text-white">Bintang Print</h4>
                    <p class="text-[11px] text-slate-400 mt-1">Jl. Raya Puncak No.38, Cisarua (Depan Royal Safari Garden).</p>
                    <div class="mt-3 p-2.5 rounded-xl bg-slate-900/60 border border-slate-800 text-xs text-slate-300 space-y-1">
                        <p>Sen-Sab: 08.00-20.00 | Min: 08.00-17.00</p>
                        <p>Digital printing cepat, banner, stiker, sablon DTF.</p>
                    </div>
                </div>
                <a href="https://maps.google.com" target="_blank" class="inline-flex items-center justify-center gap-2 w-full py-2 rounded-xl bg-slate-900 text-amber-400 border border-slate-800 text-xs font-semibold transition">
                    Petunjuk Google Maps
                </a>
            </div>

            <!-- BALE CREATIVES -->
            <div class="card-dark rounded-2xl p-5 border border-slate-800 space-y-3 flex flex-col justify-between">
                <div>
                    <h4 class="text-sm font-bold text-white">Bale Creatives Foto Copy</h4>
                    <p class="text-[11px] text-slate-400 mt-1">Jl. Desa Cilember, Kemang Gede No. 99, Cisarua.</p>
                    <div class="mt-3 p-2.5 rounded-xl bg-slate-900/60 border border-slate-800 text-xs text-slate-300 space-y-1">
                        <p>07.00 – 20.00 WIB</p>
                        <p>Cetak foto, fotokopi berkas, dan kebutuhan ATK.</p>
                    </div>
                </div>
                <a href="https://maps.google.com" target="_blank" class="inline-flex items-center justify-center gap-2 w-full py-2 rounded-xl bg-slate-900 text-amber-400 border border-slate-800 text-xs font-semibold transition">
                    Petunjuk Google Maps
                </a>
            </div>

            <!-- FOTO COPY MENTARI -->
            <div class="card-dark rounded-2xl p-5 border border-slate-800 space-y-3 flex flex-col justify-between">
                <div>
                    <h4 class="text-sm font-bold text-white">Foto Copy Mentari</h4>
                    <p class="text-[11px] text-slate-400 mt-1">Jl. Raya Puncak No.75, Cipayung Datar, Megamendung.</p>
                    <div class="mt-3 p-2.5 rounded-xl bg-slate-900/60 border border-slate-800 text-xs text-slate-300 space-y-1">
                        <p>Sen-Sab: 06.30-19.00 | Min: 12.00-19.00</p>
                        <p>Print, scan, lamaran kerja, agen transfer digital.</p>
                    </div>
                </div>
                <a href="https://maps.google.com" target="_blank" class="inline-flex items-center justify-center gap-2 w-full py-2 rounded-xl bg-slate-900 text-amber-400 border border-slate-800 text-xs font-semibold transition">
                    Petunjuk Google Maps
                </a>
            </div>

            <!-- PM FOTOCOPY 24 JAM -->
            <div class="card-dark rounded-2xl p-5 border border-amber-500/30 space-y-3 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between gap-1">
                        <h4 class="text-sm font-bold text-white">PM Fotocopy & Printing</h4>
                        <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-red-500/20 text-red-400 border border-red-500/30">
                            24 JAM
                        </span>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1">Jl. Raya Puncak KM 72, Gadog, Megamendung.</p>
                    <div class="mt-3 p-2.5 rounded-xl bg-slate-900/60 border border-slate-800 text-xs text-slate-300 space-y-1">
                        <p>Buka 24 Jam Nonstop</p>
                        <p>Solusi darurat cetak & fotokopi malam hari.</p>
                        <p class="text-emerald-400">0812-3600-6998</p>
                    </div>
                </div>
                <a href="https://maps.google.com" target="_blank" class="inline-flex items-center justify-center gap-2 w-full py-2 rounded-xl bg-slate-900 text-amber-400 border border-slate-800 text-xs font-semibold transition">
                    Petunjuk Google Maps
                </a>
            </div>

        </div>
    </div>

    <!-- SEKSI 4: TABEL ESTIMASI HARGA UMUM -->
    <div class="card-dark rounded-2xl p-6 border border-slate-800 space-y-4">
        <div>
            <h3 class="text-sm font-bold text-white">
                Perkiraan Kisaran Tarif Jasa Cetak & Jilid (Wilayah Puncak - Cisarua)
            </h3>
            <p class="text-xs text-slate-400 mt-0.5">
                *Tarif bersifat estimasi rata-rata umum. Harga asli dapat bervariasi sesuai jumlah halaman dan kebijakan masing-masing toko.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300 border-collapse">
                <thead>
                    <tr class="border-b border-slate-800 text-slate-400 bg-slate-900/50">
                        <th class="p-3">Jenis Layanan</th>
                        <th class="p-3">Estimasi Kisaran Harga</th>
                        <th class="p-3">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    <tr>
                        <td class="p-3 font-medium text-white">Fotokopi Hitam Putih (B/W)</td>
                        <td class="p-3 text-amber-400 font-semibold">Rp200 – Rp500 / lembar</td>
                        <td class="p-3 text-slate-400">Kertas A4 / Folio (F4)</td>
                    </tr>
                    <tr>
                        <td class="p-3 font-medium text-white">Fotokopi Warna</td>
                        <td class="p-3 text-amber-400 font-semibold">Rp1.500 – Rp3.000 / lembar</td>
                        <td class="p-3 text-slate-400">Tergantung kepekatan warna</td>
                    </tr>
                    <tr>
                        <td class="p-3 font-medium text-white">Print Dokumen Hitam Putih</td>
                        <td class="p-3 text-amber-400 font-semibold">Rp500 – Rp1.000 / lembar</td>
                        <td class="p-3 text-slate-400">Kertas standar HVS</td>
                    </tr>
                    <tr>
                        <td class="p-3 font-medium text-white">Print Warna Teks / Gambar</td>
                        <td class="p-3 text-amber-400 font-semibold">Rp2.000 – Rp5.000 / lembar</td>
                        <td class="p-3 text-slate-400">Tergantung jenis kertas/gambar</td>
                    </tr>
                    <tr>
                        <td class="p-3 font-medium text-white">Print Digital A3+</td>
                        <td class="p-3 text-amber-400 font-semibold">Rp2.500 – Rp5.000 / lembar</td>
                        <td class="p-3 text-slate-400">Umumnya brosur, poster, stiker</td>
                    </tr>
                    <tr>
                        <td class="p-3 font-medium text-white">Laminating</td>
                        <td class="p-3 text-amber-400 font-semibold">Rp4.000 – Rp6.000 / lembar</td>
                        <td class="p-3 text-slate-400">Ukuran KTP hingga Folio</td>
                    </tr>
                    <tr>
                        <td class="p-3 font-medium text-white">Jilid Mika / Lakban Standard</td>
                        <td class="p-3 text-amber-400 font-semibold">Rp5.000 – Rp15.000 / buku</td>
                        <td class="p-3 text-slate-400">Tergantung ketebalan berkas</td>
                    </tr>
                    <tr>
                        <td class="p-3 font-medium text-white">Jilid Hard Cover</td>
                        <td class="p-3 text-amber-400 font-semibold">Rp25.000 – Rp50.000 / buku</td>
                        <td class="p-3 text-slate-400">Proses pengerjaan butuh waktu</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection