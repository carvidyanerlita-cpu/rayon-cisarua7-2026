@extends('layouts.app')

@section('title', 'Login Portal Akses')

@section('content')
<div class="flex items-center justify-center min-h-[75vh] p-4">
    <div class="w-full max-w-md card-dark rounded-2xl p-6 sm:p-8 border border-slate-800 shadow-2xl space-y-6">

        <!-- HEADER LOGO C7 -->
        <div class="text-center space-y-3">
            <div class="flex justify-center">
                <img src="{{ asset('images/logo-c7.jpeg') }}" alt="Logo Rayon Cisarua 7" class="w-16 h-16 object-cover rounded-xl border border-slate-800 shadow-md">
            </div>
            <div>
                <h2 class="text-lg sm:text-xl font-black text-white tracking-tight">
                    Portal Akses Rayon Cisarua 7
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">
                    SMK Wikrama Bogor • Silakan masuk ke akun Anda
                </p>
            </div>
        </div>

        <!-- AKSES CEPAT / DEMO LOGIN (TANPA GURU BK & TANPA ICON) -->
        <div class="p-3 rounded-xl bg-slate-900/80 border border-slate-800 space-y-2">
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider text-center">
                AKSES CEPAT (AKUN UJI / EVALUASI):
            </div>
            <div class="grid grid-cols-2 gap-2">
                <button type="button" onclick="fillCredentials('admin@rayon.com', 'password123')" class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 border border-slate-700 text-center transition">
                    <div class="text-xs font-bold text-amber-400">Admin</div>
                    <div class="text-[9px] text-slate-400">Pengurus</div>
                </button>
                <button type="button" onclick="fillCredentials('siswa@rayon.com', 'password123')" class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 border border-slate-700 text-center transition">
                    <div class="text-xs font-bold text-sky-400">Siswa</div>
                    <div class="text-[9px] text-slate-400">Anggota</div>
                </button>
            </div>
        </div>

        <!-- FORM LOGIN -->
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- ALAMAT EMAIL -->
            <div class="space-y-1">
                <label class="block text-xs font-semibold text-slate-300">Alamat Email</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autofocus
                       placeholder="admin@rayon.com"
                       class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-amber-400 transition">
                @error('email')
                    <p class="text-[10px] text-rose-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- KATA SANDI -->
            <div class="space-y-1">
                <label class="block text-xs font-semibold text-slate-300">Kata Sandi</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       required 
                       placeholder="••••••••"
                       class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-amber-400 transition">
                @error('password')
                    <p class="text-[10px] text-rose-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- INGAT SESI & INFO DEFAULT -->
            <div class="flex items-center justify-between text-xs text-slate-400 pt-1">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="rounded bg-slate-900 border-slate-800 text-amber-400 focus:ring-0">
                    <span>Ingat sesi saya</span>
                </label>
                <span class="text-[10px] text-slate-500">Default: password123</span>
            </div>

            <!-- TOMBOL MASUK DIPERJELAS -->
            <div class="pt-2">
                <button type="submit" class="w-full py-3 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-bold text-xs text-center transition shadow-lg shadow-amber-400/10">
                    Masuk ke Dashboard
                </button>
            </div>
        </form>

        <div class="pt-2 text-center text-[10px] text-slate-500 border-t border-slate-800">
            Sistem Informasi Rayon Cisarua 7 • Wikrama Disiplin, Jujur & Berintegritas
        </div>

    </div>
</div>

<script>
    function fillCredentials(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
    }
</script>
@endsection