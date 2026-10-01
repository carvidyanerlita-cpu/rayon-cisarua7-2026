<?php

namespace App\Http\Controllers;

use App\Models\BkPost;
use App\Models\Member;
use App\Models\Photocopy;
use App\Models\PiketLog;
use App\Models\PulangBareng;
use App\Models\PulangComment;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalMembers = Member::count();
        $pklMembersCount = Member::where('is_pkl', true)->count();
        $activeMembersCount = Member::where('is_pkl', false)->count();

        // Sanctioned members
        $sanctionedMembers = Member::where('sanction_active', true)
            ->orderBy('sanction_until', 'asc')
            ->get();
        $sanctionedCount = $sanctionedMembers->count();

        // Calculate attendance rate (from non-PKL piket logs)
        $today = Carbon::today()->format('Y-m-d');
        $totalLogs = PiketLog::whereHas('member', fn ($q) => $q->where('is_pkl', false))->count();
        $hadirLogs = PiketLog::whereHas('member', fn ($q) => $q->where('is_pkl', false))
            ->where('status', 'Hadir')
            ->count();

        $attendanceRate = $totalLogs > 0 ? round(($hadirLogs / $totalLogs) * 100, 1) : 100.0;

        // Current Day Name in Indonesian
        $daysMap = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            0 => 'Minggu',
        ];
        $currentDayIndo = $daysMap[Carbon::now()->dayOfWeek] ?? 'Senin';
        $todayPiketDay = in_array($currentDayIndo, ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'], true)
            ? $currentDayIndo
            : 'Senin';

        // Members scheduled for piket today
        $todayPiketMembers = Member::where('piket_day', $todayPiketDay)
            ->with(['latestPiketLog'])
            ->get();

        // Pulang Bareng overview for today
        $pulangCepatCount = PulangBareng::where('date', $today)
            ->where('jam_pulang', '16:00')
            ->count();
        $pulangRegulerCount = PulangBareng::where('date', $today)
            ->where('jam_pulang', '17:30')
            ->count();

        // Latest traffic updates & BK articles
        $latestComment = PulangComment::latest()->first();
        $recentArticles = BkPost::articles()->latest()->take(3)->get();
        $photocopiesCount = Photocopy::count();

        return view('dashboard.index', compact(
            'totalMembers',
            'activeMembersCount',
            'pklMembersCount',
            'sanctionedCount',
            'sanctionedMembers',
            'attendanceRate',
            'currentDayIndo',
            'todayPiketDay',
            'todayPiketMembers',
            'pulangCepatCount',
            'pulangRegulerCount',
            'latestComment',
            'recentArticles',
            'photocopiesCount'
        ));
    }
}
