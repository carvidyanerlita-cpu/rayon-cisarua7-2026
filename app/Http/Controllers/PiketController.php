<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\PiketLog;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PiketController extends Controller
{
    public function index(Request $request): View
    {
        $selectedDate = $request->input('date', Carbon::today()->format('Y-m-d'));
        $selectedDay = $request->input('day', 'Semua');

        $query = Member::query()->with(['piketLogs' => function ($q) use ($selectedDate) {
            $q->where('date', $selectedDate);
        }]);

        if ($selectedDay !== 'Semua') {
            $query->where('piket_day', $selectedDay);
        }

        $members = $query->orderBy('nis', 'asc')->get();

        // Get logs for the selected date to generate statistics & WhatsApp announcement
        $logs = PiketLog::with('member')->where('date', $selectedDate)->get();

        $hadirList = [];
        $izinList = [];
        $sakitList = [];
        $alpaList = [];
        $pklList = [];

        foreach ($logs as $log) {
            $member = $log->member;
            if (! $member) {
                continue;
            }

            if ($log->status === 'PKL' || $member->is_pkl) {
                $pklList[] = "• {$member->name} ({$member->nis})";
            } elseif ($log->status === 'Hadir') {
                $hadirList[] = "• {$member->name} ({$member->nis})";
            } elseif ($log->status === 'Izin') {
                $note = $log->notes ? " - {$log->notes}" : '';
                $izinList[] = "• {$member->name} ({$member->nis}){$note}";
            } elseif ($log->status === 'Sakit') {
                $note = $log->notes ? " - {$log->notes}" : '';
                $sakitList[] = "• {$member->name} ({$member->nis}){$note}";
            } elseif ($log->status === 'Alpa') {
                $alpaList[] = "• {$member->name} ({$member->nis}) - [Sanksi 7 Hari Aktif s/d ".($member->sanction_until ? Carbon::parse($member->sanction_until)->format('d M Y') : 'Minggu Depan').']';
            }
        }

        $totalHadir = count($hadirList);
        $totalIzin = count($izinList);
        $totalSakit = count($sakitList);
        $totalAlpa = count($alpaList);
        $totalPkl = count($pklList);
        $totalActiveExpected = $totalHadir + $totalIzin + $totalSakit + $totalAlpa;
        $attendanceRate = $totalActiveExpected > 0 ? round(($totalHadir / $totalActiveExpected) * 100, 1) : 100;

        $formattedDate = Carbon::parse($selectedDate)->translatedFormat('l, d F Y');

        // Build WhatsApp text
        $waText = "*LAPORAN PIKET HARIAN RAYON CISARUA 7*\n";
        $waText .= "*SMK WIKRAMA BOGOR*\n";
        $waText .= "📅 Tanggal: {$formattedDate}\n\n";

        $waText .= '✅ *HADIR ('.count($hadirList)." Siswa)*:\n";
        $waText .= empty($hadirList) ? "- NIHIL\n" : implode("\n", $hadirList)."\n";
        $waText .= "\n";

        $waText .= '📋 *IZIN ('.count($izinList)." Siswa)*:\n";
        $waText .= empty($izinList) ? "- NIHIL\n" : implode("\n", $izinList)."\n";
        $waText .= "\n";

        $waText .= '🏥 *SAKIT ('.count($sakitList)." Siswa)*:\n";
        $waText .= empty($sakitList) ? "- NIHIL\n" : implode("\n", $sakitList)."\n";
        $waText .= "\n";

        $waText .= '❌ *ALPA / SANKSI 7 HARI ('.count($alpaList)." Siswa)*:\n";
        $waText .= empty($alpaList) ? "- NIHIL\n" : implode("\n", $alpaList)."\n";
        $waText .= "\n";

        $waText .= '💼 *SEDANG PKL ('.count($pklList)." Siswa)*:\n";
        $waText .= empty($pklList) ? "- NIHIL\n" : implode("\n", $pklList)."\n";
        $waText .= "\n";

        $waText .= "📊 *Tingkat Kehadiran Aktif*: {$attendanceRate}%\n";
        $waText .= '_Dicatat oleh Pengurus Rayon Cisarua 7 - SMK Wikrama Bogor_';

        return view('piket.index', compact(
            'members',
            'selectedDate',
            'selectedDay',
            'totalHadir',
            'totalIzin',
            'totalSakit',
            'totalAlpa',
            'totalPkl',
            'attendanceRate',
            'waText'
        ));
    }

    public function updateStatus(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'member_id' => ['required', 'exists:members,id'],
            'status' => ['required', 'in:Hadir,Izin,Sakit,Alpa,PKL'],
            'date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        $member = Member::findOrFail($validated['member_id']);

        // PKL members rule: must stay PKL and cannot be Alpa
        if ($member->is_pkl) {
            $validated['status'] = 'PKL';
            $validated['notes'] = $validated['notes'] ?? 'Sedang Praktek Kerja Lapangan (PKL)';
        }

        // Automatic sanction for regular members on Alpa
        if (! $member->is_pkl && $validated['status'] === 'Alpa') {
            $member->sanction_active = true;
            // 7 days consecutive sanction starting from date
            $member->sanction_until = Carbon::parse($validated['date'])->addDays(7)->format('Y-m-d');
            $member->save();
        }

        $existingLog = PiketLog::where('member_id', $member->id)
            ->whereDate('date', $validated['date'])
            ->first();

        if ($existingLog) {
            $existingLog->update([
                'status' => $validated['status'],
                'notes' => $validated['notes'],
            ]);
        } else {
            PiketLog::create([
                'member_id' => $member->id,
                'date' => $validated['date'],
                'status' => $validated['status'],
                'notes' => $validated['notes'],
            ]);
        }

        $message = "Status piket {$member->name} berhasil diperbarui menjadi {$validated['status']}.";
        if (! $member->is_pkl && $validated['status'] === 'Alpa') {
            $message .= ' Sanksi piket 7 hari otomatis diaktifkan hingga '.Carbon::parse($member->sanction_until)->format('d/m/Y').'!';
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'member' => $member->fresh(),
            ]);
        }

        return back()->with('success', $message);
    }

    public function resolveSanction(Member $member): RedirectResponse
    {
        $member->update([
            'sanction_active' => false,
            'sanction_until' => null,
        ]);

        return back()->with('success', "Sanksi piket untuk {$member->name} telah dicabut/diselesaikan.");
    }
}
