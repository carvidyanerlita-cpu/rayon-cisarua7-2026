@extends('layouts.app')

@section('title', 'Data Anggota Rayon Cisarua 7')

@section('content')
<div class="space-y-6" x-data="{ openAddModal: false, editMember: null }">

    <!-- HEADER & ACTION BUTTON -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">
                Data Anggota Rayon Cisarua 7
            </h1>
            <p class="text-xs text-slate-400 mt-1"> Kelola data siswa, status PKL, dan sanksi piket secara terpusat.</p>
        </div>

        @auth
        @if(Auth::user()->isAdmin())
        <button @click="openAddModal = true"
            class="px-4 py-2.5 rounded-xl bg-gold-500 hover:bg-gold-400 text-slate-950 font-bold text-xs transition shadow-lg flex items-center gap-2 self-start md:self-auto">
            <i class="fa-solid fa-user-plus"></i>
            Tambah Anggota Baru
        </button>
        @endif
        @endauth
    </div>

    <!-- METRICS STRIP -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5">
        <div class="p-4 rounded-xl bg-slate-900 border border-slate-800 shadow-sm">
            <span class="text-[10px] font-bold uppercase text-slate-400">Total Anggota</span>
            <h4 class="text-2xl font-black text-white mt-0.5">{{ $totalMembers }}</h4>
            <span class="text-[10px] text-slate-500">Rayon Cisarua 7</span>
        </div>
        <div class="p-4 rounded-xl bg-slate-900 border border-slate-800 shadow-sm">
            <span class="text-[10px] font-bold uppercase text-slate-400">Aktif di Sekolah</span>
            <h4 class="text-2xl font-black text-emerald-400 mt-0.5">{{ $totalMembers - $totalPkl }}</h4>
            <span class="text-[10px] text-slate-500">Piket Reguler</span>
        </div>
        <div class="p-4 rounded-xl bg-slate-900 border border-slate-800 shadow-sm">
            <span class="text-[10px] font-bold uppercase text-slate-400">Sedang PKL (Industri)</span>
            <h4 class="text-2xl font-black text-sky-400 mt-0.5">{{ $totalPkl }}</h4>
            <span class="text-[10px] text-slate-500">Bebas Tugas Piket</span>
        </div>
        <div class="p-4 rounded-xl bg-slate-900 border border-slate-800 shadow-sm">
            <span class="text-[10px] font-bold uppercase text-slate-400">Sanksi Aktif</span>
            <h4 class="text-2xl font-black text-red-400 mt-0.5">{{ $totalSanctioned }}</h4>
            <span class="text-[10px] text-slate-500">Piket 7 Hari</span>
        </div>
    </div>

    <!-- FILTER & SEARCH BAR -->
    <div class="bg-slate-900 rounded-2xl p-4 shadow-lg border border-slate-800">
        <form method="GET" action="{{ route('members.index') }}" class="flex flex-wrap items-center justify-between gap-3">

            <div class="flex flex-wrap items-center gap-3 flex-1">
                <!-- Search Box -->
                <div class="relative min-w-[220px]">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari nama atau NIS siswa..."
                        class="w-full pl-8 pr-3 py-1.5 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:border-gold-400 focus:ring-0">
                </div>

                <!-- Piket Day Filter -->
                <select name="piket_day" onchange="this.form.submit()" class="px-3 py-1.5 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:border-gold-400 focus:ring-0">
                    <option value="Semua" {{ empty($piketDay) || $piketDay === 'Semua' ? 'selected' : '' }}>Semua Hari Piket</option>
                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $day)
                    <option value="{{ $day }}" {{ $piketDay === $day ? 'selected' : '' }}>Piket {{ $day }}</option>
                    @endforeach
                </select>

                <!-- PKL Status Filter -->
                <select name="is_pkl" onchange="this.form.submit()" class="px-3 py-1.5 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:border-gold-400 focus:ring-0">
                    <option value="" {{ $statusPkl === null || $statusPkl === '' ? 'selected' : '' }}>Semua Status Siswa</option>
                    <option value="1" {{ $statusPkl === '1' ? 'selected' : '' }}>Sedang PKL</option>
                    <option value="0" {{ $statusPkl === '0' ? 'selected' : '' }}>Siswa Aktif Sekolah</option>
                </select>

                <button type="submit" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-gold-400 text-xs font-bold transition">
                    Terapkan
                </button>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('members.index') }}" class="px-2.5 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-medium transition" title="Reset Filter">
                    <i class="fa-solid fa-rotate-right"></i> Reset
                </a>
            </div>

        </form>
    </div>

    <!-- MEMBERS TABLE -->
    <div class="bg-slate-900 rounded-2xl p-5 shadow-xl border border-slate-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 border-b border-slate-800 uppercase tracking-wider text-[10px]">
                        <th class="py-2.5 px-3">NIS</th>
                        <th class="py-2.5 px-3">Nama Anggota</th>
                        <th class="py-2.5 px-3">Jadwal Piket</th>
                        <th class="py-2.5 px-3">Status</th>
                        <th class="py-2.5 px-3">Sanksi</th>
                        <th class="py-2.5 px-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium">
                    @forelse($members as $m)
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="py-3 px-3 font-mono text-slate-300 font-bold">{{ $m->nis }}</td>
                        <td class="py-3 px-3">
                            <div class="font-bold text-white">{{ $m->name }}</div>
                        </td>
                        <td class="py-3 px-3">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-950 text-slate-300 border border-slate-800">
                                {{ $m->piket_day }}
                            </span>
                        </td>
                        <td class="py-3 px-3">
                            @if($m->is_pkl)
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-sky-500/20 text-sky-300 border border-sky-500/40">
                                Sedang PKL
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/40">
                                Aktif Sekolah
                            </span>
                            @endif
                        </td>
                        <td class="py-3 px-3">
                            @if($m->sanction_active)
                            <div class="space-y-0.5">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-red-500/20 text-red-300 border border-red-500/40">
                                    Piket 7 Hari
                                </span>
                                <p class="text-[10px] text-red-400">s/d {{ \Carbon\Carbon::parse($m->sanction_until)->format('d M Y') }}</p>
                            </div>
                            @else
                            <span class="text-slate-500 text-[11px]">-</span>
                            @endif
                        </td>
                        <td class="py-3 px-3 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <!-- Toggle PKL -->
                                <form action="{{ route('members.toggle-pkl', $m->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        title="{{ $m->is_pkl ? 'Ubah ke Aktif Sekolah' : 'Ubah ke Sedang PKL' }}"
                                        class="p-1.5 rounded-lg text-xs bg-slate-800 hover:bg-sky-500/20 text-slate-400 hover:text-sky-300 border border-slate-700 transition">
                                        <i class="fa-solid fa-briefcase"></i>
                                    </button>
                                </form>

                                <!-- Toggle Sanction -->
                                <form action="{{ route('members.toggle-sanction', $m->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        title="{{ $m->sanction_active ? 'Cabut Sanksi' : 'Beri Sanksi 7 Hari' }}"
                                        class="p-1.5 rounded-lg text-xs {{ $m->sanction_active ? 'bg-red-500/20 text-red-400 border border-red-500/40' : 'bg-slate-800 text-slate-400 border border-slate-700' }} hover:bg-red-500/30 transition">
                                        <i class="fa-solid fa-gavel"></i>
                                    </button>
                                </form>

                                <!-- Edit Button -->
                                <button @click="editMember = @js($m)"
                                    title="Edit Data Siswa"
                                    class="p-1.5 rounded-lg text-xs bg-slate-800 hover:bg-gold-500/20 text-slate-400 hover:text-gold-300 border border-slate-700 transition">
                                    <i class="fa-solid fa-pen"></i>
                                </button>

                                <!-- Delete Button -->
                                @auth
                                @if(Auth::user()->isAdmin())
                                <form action="{{ route('members.destroy', $m->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus siswa {{ $m->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Siswa" class="p-1.5 rounded-lg text-xs bg-slate-800 hover:bg-red-500/20 text-slate-400 hover:text-red-400 border border-slate-700 transition">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                                @endif
                                @endauth
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500">
                            Tidak ada data anggota yang sesuai dengan kriteria filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 pt-3 border-t border-slate-800">
            {{ $members->links() }}
        </div>
    </div>

    <!-- MODAL TAMBAH ANGGOTA -->
    <div x-show="openAddModal"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div @click.away="openAddModal = false" class="bg-slate-900 rounded-2xl p-6 w-full max-w-md shadow-2xl border border-slate-800">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800 mb-4">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-user-plus text-gold-400"></i>
                    Tambah Anggota Rayon
                </h3>
                <button @click="openAddModal = false" class="text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ route('members.store') }}" method="POST" class="space-y-3.5">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Nomor Induk Siswa (NIS):</label>
                    <input type="text"
                        name="nis"
                        required
                        placeholder="Misal: 12100046"
                        class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:border-gold-400 focus:ring-0">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Nama Lengkap Siswa:</label>
                    <input type="text"
                        name="name"
                        required
                        placeholder="Misal: Ahmad Zaky"
                        class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:border-gold-400 focus:ring-0">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Jadwal Hari Piket:</label>
                    <select name="piket_day" required class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:border-gold-400 focus:ring-0">
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                    </select>
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" id="add_is_pkl" name="is_pkl" value="1" class="rounded bg-slate-950 border-slate-700 text-sky-500 focus:ring-0">
                    <label for="add_is_pkl" class="text-xs text-slate-300">Set sebagai <strong>Sedang PKL</strong> (Bebas Alpa Piket)</label>
                </div>

                <div class="pt-3">
                    <button type="submit" class="w-full py-2.5 rounded-xl bg-gold-500 hover:bg-gold-400 text-slate-950 font-bold text-xs transition shadow flex items-center justify-center gap-2">
                        <i class="fa-solid fa-save"></i>
                        Simpan Anggota Baru
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT ANGGOTA -->
    <div x-show="editMember !== null"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div @click.away="editMember = null" class="bg-slate-900 rounded-2xl p-6 w-full max-w-md shadow-2xl border border-slate-800">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800 mb-4">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-gold-400"></i>
                    Edit Data Anggota
                </h3>
                <button @click="editMember = null" class="text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <template x-if="editMember">
                <form :action="'{{ url('members') }}/' + editMember.id" method="POST" class="space-y-3.5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1">Nomor Induk Siswa (NIS):</label>
                        <input type="text"
                            name="nis"
                            x-model="editMember.nis"
                            required
                            class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:border-gold-400 focus:ring-0">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1">Nama Lengkap Siswa:</label>
                        <input type="text"
                            name="name"
                            x-model="editMember.name"
                            required
                            class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:border-gold-400 focus:ring-0">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1">Jadwal Hari Piket:</label>
                        <select name="piket_day" x-model="editMember.piket_day" required class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:border-gold-400 focus:ring-0">
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                        </select>
                    </div>

                    <div class="space-y-2 pt-1 border-t border-slate-800">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="edit_is_pkl" name="is_pkl" value="1" :checked="editMember.is_pkl" class="rounded bg-slate-950 border-slate-700 text-sky-500 focus:ring-0">
                            <label for="edit_is_pkl" class="text-xs text-slate-300">Status <strong>Sedang PKL</strong></label>
                        </div>

                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="edit_sanction" name="sanction_active" value="1" :checked="editMember.sanction_active" class="rounded bg-slate-950 border-slate-700 text-red-500 focus:ring-0">
                            <label for="edit_sanction" class="text-xs text-slate-300">Aktifkan <strong>Sanksi Piket 7 Hari</strong></label>
                        </div>
                    </div>

                    <div class="pt-3">
                        <button type="submit" class="w-full py-2.5 rounded-xl bg-gold-500 hover:bg-gold-400 text-slate-950 font-bold text-xs transition shadow flex items-center justify-center gap-2">
                            <i class="fa-solid fa-save"></i>
                            Perbarui Data Siswa
                        </button>
                    </div>
                </form>
            </template>
        </div>
    </div>

</div>
@endsection