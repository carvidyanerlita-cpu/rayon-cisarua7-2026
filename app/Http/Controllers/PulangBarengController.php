<?php

namespace App\Http\Controllers;

use App\Models\PulangBareng;
use App\Models\PulangComment;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PulangBarengController extends Controller
{
    public function index(): View
    {
        $today = Carbon::today()->format('Y-m-d');

        $rombongan1600 = PulangBareng::where('date', $today)
            ->where('jam_pulang', '16:00')
            ->orderBy('created_at', 'asc')
            ->get();

        $rombongan1730 = PulangBareng::where('date', $today)
            ->where('jam_pulang', '17:30')
            ->orderBy('created_at', 'asc')
            ->get();

        $userEntry = Auth::check()
            ? PulangBareng::where('date', $today)->where('user_id', Auth::id())->first()
            : null;

        $comments = PulangComment::orderBy('created_at', 'desc')->take(20)->get();

        return view('pulang.index', compact(
            'today',
            'rombongan1600',
            'rombongan1730',
            'userEntry',
            'comments'
        ));
    }

    public function join(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_name' => ['required', 'string', 'max:100'],
            'jam_pulang' => ['required', 'in:16:00,17:30'],
            'titik_kumpul' => ['required', 'string', 'max:100'],
            'tujuan' => ['required', 'string', 'max:100'],
        ]);

        $today = Carbon::today()->format('Y-m-d');
        $userId = Auth::id();

        // If user logged in, check if already joined today and update
        if ($userId) {
            PulangBareng::updateOrCreate(
                ['user_id' => $userId, 'date' => $today],
                [
                    'student_name' => $validated['student_name'],
                    'jam_pulang' => $validated['jam_pulang'],
                    'titik_kumpul' => $validated['titik_kumpul'],
                    'tujuan' => $validated['tujuan'],
                ]
            );
        } else {
            PulangBareng::create([
                'user_id' => null,
                'student_name' => $validated['student_name'],
                'date' => $today,
                'jam_pulang' => $validated['jam_pulang'],
                'titik_kumpul' => $validated['titik_kumpul'],
                'tujuan' => $validated['tujuan'],
            ]);
        }

        return redirect()->route('pulang.index')
            ->with('success', "Berhasil bergabung di rombongan Pulang {$validated['jam_pulang']} WIB!");
    }

    public function cancel(int $id): RedirectResponse
    {
        $entry = PulangBareng::findOrFail($id);

        // Allow deletion if user owns entry or is admin
        if (! Auth::check() || Auth::user()->isAdmin() || $entry->user_id === Auth::id()) {
            $entry->delete();

            return redirect()->route('pulang.index')
                ->with('success', 'Keikutsertaan rombongan berhasil dibatalkan.');
        }

        return redirect()->route('pulang.index')
            ->with('error', 'Anda tidak memiliki hak untuk membatalkan rombongan siswa lain.');
    }

    public function storeComment(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'author_name' => ['required', 'string', 'max:100'],
            'traffic_status' => ['required', 'string', 'in:Lancar,Padat,Macet,One Way'],
            'comment' => ['required', 'string', 'max:500'],
        ]);

        PulangComment::create([
            'author_name' => $validated['author_name'],
            'traffic_status' => $validated['traffic_status'],
            'date' => Carbon::today()->format('Y-m-d'),
            'comment' => $validated['comment'],
        ]);

        return redirect()->route('pulang.index')
            ->with('success', 'Informasi lalu lintas & angkot berhasil dikirim ke papan diskusi.');
    }
}
