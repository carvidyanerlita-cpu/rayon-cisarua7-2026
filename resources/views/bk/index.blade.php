@extends('layouts.app')

@section('title', 'Literasi & Infografis Parenting')

@section('content')
<div class="space-y-6" x-data="{ openUploadModal: false }">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight mt-1">
                Literasi & Infografis Parenting
            </h2>
            <p class="text-xs text-slate-400 max-w-2xl mt-0.5">
                Materi visual, panduan parenting, dan infografis pengembangan karakter siswa.
            </p>
        </div>

        @if($isAdmin)
        <button @click="openUploadModal = true"
            class="px-4 py-2.5 rounded-xl gold-gradient text-slate-950 font-bold text-xs hover:brightness-110 transition shadow-lg flex items-center gap-2 self-start md:self-auto">
            <i class="fa-solid fa-cloud-arrow-up"></i>
            Upload Infografis Baru
        </button>
        @endif
    </div>

    <!-- FILTER KATEGORI -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs">
        <span class="text-slate-500 font-semibold mr-1">Kategori:</span>
        <a href="{{ route('bk.index') }}"
            class="px-3 py-1 rounded-lg font-medium transition {{ empty($category) || $category === 'Semua' ? 'bg-gold-400 text-slate-950 font-bold' : 'bg-slate-900 text-slate-400 border border-slate-800' }}">
            Semua Kategori
        </a>
        @foreach(['Parenting', 'Tips Belajar & Karakter', 'Kesehatan Mental', 'Persiapan PKL'] as $cat)
        <a href="{{ route('bk.index', ['category' => $cat]) }}"
            class="px-3 py-1 rounded-lg font-medium whitespace-nowrap transition {{ $category === $cat ? 'bg-gold-400 text-slate-950 font-bold' : 'bg-slate-900 text-slate-400 border border-slate-800' }}">
            {{ $cat }}
        </a>
        @endforeach
    </div>

    <!-- GRID INFOGRAFIS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($articles as $article)
        <div class="card-dark card-dark-hover rounded-2xl overflow-hidden shadow-xl border border-gold-500/20 flex flex-col justify-between transition group">
            <div>
                <!-- WADAH FOTO/INFOGRAFIS -->
                <div class="relative overflow-hidden bg-slate-950 aspect-video">
                    @if($article->image)
                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-slate-900 text-slate-600 text-xs">
                        <i class="fa-regular fa-image text-3xl mr-2"></i> Tidak ada gambar
                    </div>
                    @endif
                    <span class="absolute top-3 left-3 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-950/80 text-gold-400 border border-gold-400/30 backdrop-blur-md">
                        {{ $article->category }}
                    </span>
                </div>

                <!-- KONTEN TEKS -->
                <div class="p-5 space-y-2">
                    <h3 class="text-sm font-bold text-white leading-snug group-hover:text-gold-300 transition">
                        {{ $article->title }}
                    </h3>
                    @if($article->content)
                    <p class="text-xs text-slate-400 line-clamp-3 leading-relaxed">
                        {{ $article->content }}
                    </p>
                    @endif
                </div>
            </div>

            <div class="p-5 pt-0 flex items-center justify-between text-[10px] text-slate-500 border-t border-slate-800/50 mt-3 pt-3">
                <span><i class="fa-regular fa-calendar mr-1"></i>{{ $article->created_at->translatedFormat('d M Y') }}</span>
                @if($isAdmin)
                <form action="{{ route('bk.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Hapus infografis ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-400 hover:text-red-300 font-semibold">
                        <i class="fa-solid fa-trash mr-1"></i>Hapus
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 text-center text-slate-500 text-xs card-dark rounded-2xl border border-slate-800">
            <i class="fa-solid fa-folder-open text-3xl mb-2 text-slate-600"></i>
            <p>Belum ada materi infografis yang diunggah.</p>
        </div>
        @endforelse
    </div>

    <!-- MODAL UPLOAD INFOGRAFIS (HANYA ADMIN) -->
    @if($isAdmin)
    <div x-show="openUploadModal"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div @click.away="openUploadModal = false" class="card-dark rounded-2xl p-6 w-full max-w-lg shadow-2xl border border-gold-500/30 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                <h3 class="text-sm font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-cloud-arrow-up text-gold-400"></i>
                    Upload Infografis / Gambar Parenting (Admin)
                </h3>
                <button @click="openUploadModal = false" class="text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ route('bk.article.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3.5">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Gambar Infografis (JPG, PNG, WEBP max 3MB):</label>
                    <input type="file"
                        name="image"
                        accept="image/*"
                        required
                        class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-xs text-slate-300 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-gold-500 file:text-slate-950 hover:file:bg-gold-400">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Judul Infografis:</label>
                    <input type="text"
                        name="title"
                        required
                        placeholder="Misal: Panduan Mendampingi Anak Saat PKL"
                        class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-xs text-white focus:border-gold-400 focus:ring-0">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Kategori:</label>
                    <select name="category" required class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-xs text-white focus:border-gold-400 focus:ring-0">
                        <option value="Parenting">Parenting</option>
                        <option value="Tips Belajar & Karakter">Tips Belajar & Karakter</option>
                        <option value="Kesehatan Mental">Kesehatan Mental</option>
                        <option value="Persiapan PKL">Persiapan PKL</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Keterangan Singkat (Opsional):</label>
                    <textarea name="content"
                        rows="3"
                        placeholder="Tambahkan penjelasan singkat dari infografis ini..."
                        class="w-full p-3 rounded-xl bg-slate-900 border border-slate-700 text-xs text-white focus:border-gold-400 focus:ring-0 resize-none"></textarea>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3 rounded-xl gold-gradient text-slate-950 font-bold text-xs hover:brightness-110 transition shadow flex items-center justify-center gap-2">
                        <i class="fa-solid fa-upload"></i>
                        Unggah Infografis
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

</div>
@endsection