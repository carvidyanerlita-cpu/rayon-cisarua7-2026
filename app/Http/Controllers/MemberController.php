<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $piketDay = $request->input('piket_day');
        $statusPkl = $request->input('is_pkl');

        $query = Member::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        if ($piketDay && $piketDay !== 'Semua') {
            $query->where('piket_day', $piketDay);
        }

        if ($statusPkl !== null && $statusPkl !== '') {
            $query->where('is_pkl', (bool) $statusPkl);
        }

        $members = $query->orderBy('nis', 'asc')->paginate(15)->withQueryString();

        $totalMembers = Member::count();
        $totalPkl = Member::where('is_pkl', true)->count();
        $totalSanctioned = Member::where('sanction_active', true)->count();

        return view('members.index', compact(
            'members',
            'search',
            'piketDay',
            'statusPkl',
            'totalMembers',
            'totalPkl',
            'totalSanctioned'
        ));
}

public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:20', 'unique:members,nis'],
            'name' => ['required', 'string', 'max:100'],
            'piket_day' => ['required', 'in:Senin,Selasa,Rabu,Kamis,Jumat'],
            'is_pkl' => ['nullable', 'boolean'],
        ]);

        // Mengambil nilai boolean dengan lebih bersih
        $validated['is_pkl'] = $request->boolean('is_pkl');

        Member::create($validated);

        return redirect()->route('members.index')
            ->with('success', "Anggota {$validated['name']} berhasil ditambahkan ke Rayon Cisarua 7.");
    }

    public function update(Request $request, Member $member): RedirectResponse
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:20', Rule::unique('members')->ignore($member->id)],
            'name' => ['required', 'string', 'max:100'],
            'piket_day' => ['required', 'in:Senin,Selasa,Rabu,Kamis,Jumat'],
            'is_pkl' => ['nullable', 'boolean'],
            'sanction_active' => ['nullable', 'boolean'],
            'sanction_until' => ['nullable', 'date'],
        ]);

        $sanctionActive = $request->boolean('sanction_active');

        $validated['is_pkl'] = $request->boolean('is_pkl');
        $validated['sanction_active'] = $sanctionActive;

        // Logika tanggal sanksi otomatis jika diaktifkan dari modal edit
        if (!$sanctionActive) {
            $validated['sanction_until'] = null;
        } elseif (empty($validated['sanction_until'])) {
            $validated['sanction_until'] = Carbon::today()->addDays(7)->format('Y-m-d');
        }

        $member->update($validated);

        return redirect()->route('members.index')
            ->with('success', "Data {$member->name} berhasil diperbarui.");
    }

    public function destroy(Member $member): RedirectResponse
    {
        $name = $member->name;
        $member->delete();

        return redirect()->route('members.index')
            ->with('success', "Anggota {$name} berhasil dihapus dari data rayon.");
    }

    public function toggleSanction(Member $member): RedirectResponse
    {
        if ($member->sanction_active) {
            $member->update([
                'sanction_active' => false,
                'sanction_until' => null,
            ]);
            $msg = "Sanksi untuk {$member->name} dinonaktifkan.";
        } else {
            $member->update([
                'sanction_active' => true,
                'sanction_until' => Carbon::today()->addDays(7)->format('Y-m-d'),
            ]);
            $msg = "Sanksi 7 hari untuk {$member->name} diaktifkan.";
        }

        return back()->with('success', $msg);
    }

    public function togglePkl(Member $member): RedirectResponse
    {
        $member->is_pkl = ! $member->is_pkl;
        $member->save();

        $statusStr = $member->is_pkl ? 'Sedang PKL' : 'Aktif Sekolah';

        return back()->with('success', "Status {$member->name} diubah menjadi {$statusStr}.");
    }
}
