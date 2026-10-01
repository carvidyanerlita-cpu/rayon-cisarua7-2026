<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\PiketLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CisaruaRayonTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_seeder_initializes_45_members_with_exact_9_pkl_students(): void
    {
        $this->assertDatabaseCount('members', 45);
        $this->assertEquals(9, Member::where('is_pkl', true)->count());
        $this->assertEquals(36, Member::where('is_pkl', false)->count());

        // Exactly numbers 37 to 45 are PKL
        for ($i = 37; $i <= 45; $i++) {
            $nis = (string) (12100000 + $i);
            $member = Member::where('nis', $nis)->first();
            $this->assertNotNull($member);
            $this->assertTrue($member->is_pkl);
        }

        // Numbers 1 to 36 are NOT PKL
        for ($i = 1; $i <= 36; $i++) {
            $nis = (string) (12100000 + $i);
            $member = Member::where('nis', $nis)->first();
            $this->assertNotNull($member);
            $this->assertFalse($member->is_pkl);
        }
    }

    public function test_user_authentication_roles_exist(): void
    {
        $this->assertDatabaseHas('users', ['email' => 'admin@rayon.com', 'role' => 'admin']);
        $this->assertDatabaseHas('users', ['email' => 'gurubk@rayon.com', 'role' => 'gurubk']);
        $this->assertDatabaseHas('users', ['email' => 'siswa@rayon.com', 'role' => 'siswa']);
    }

    public function test_dashboard_displays_all_5_metrics_and_branding(): void
    {
        $response = $this->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('RAYON CISARUA 7');
        $response->assertSee('SMK Wikrama Bogor');
        $response->assertSee('Sistem Informasi, Piket &amp; Transportasi Harian', false);
        $response->assertSee('45'); // Total members
        $response->assertSee('36'); // Aktif Sekolah
        $response->assertSee('9');  // Sedang PKL
    }

    public function test_alpa_status_triggers_automatic_7_day_sanction(): void
    {
        $regularMember = Member::where('is_pkl', false)->where('sanction_active', false)->first();
        $this->assertNotNull($regularMember);

        $today = Carbon::today()->format('Y-m-d');

        $response = $this->post(route('piket.update-status'), [
            'member_id' => $regularMember->id,
            'status' => 'Alpa',
            'date' => $today,
            'notes' => 'Tidak hadir tanpa keterangan',
        ]);

        $response->assertRedirect();

        $regularMember->refresh();
        $this->assertTrue($regularMember->sanction_active);
        $this->assertNotNull($regularMember->sanction_until);
        $this->assertEquals(Carbon::today()->addDays(7)->format('Y-m-d'), $regularMember->sanction_until->format('Y-m-d'));

        // Log is saved as Alpa
        $this->assertDatabaseHas('piket_logs', [
            'member_id' => $regularMember->id,
            'status' => 'Alpa',
        ]);
    }

    public function test_pkl_member_is_locked_as_pkl_and_cannot_be_marked_alpa(): void
    {
        $pklMember = Member::where('is_pkl', true)->first();
        $this->assertNotNull($pklMember);

        $today = Carbon::today()->format('Y-m-d');

        // Attempting to set Alpa on PKL member
        $response = $this->post(route('piket.update-status'), [
            'member_id' => $pklMember->id,
            'status' => 'Alpa',
            'date' => $today,
            'notes' => 'Coba alpa',
        ]);

        $response->assertRedirect();

        $pklMember->refresh();
        // Sanksi must NOT be triggered
        $this->assertFalse($pklMember->sanction_active);

        // Status must be preserved as PKL
        $this->assertDatabaseHas('piket_logs', [
            'member_id' => $pklMember->id,
            'status' => 'PKL',
        ]);
    }

    public function test_pulang_bareng_polling_and_traffic_comment(): void
    {
        $today = Carbon::today()->format('Y-m-d');

        $response = $this->post(route('pulang.join'), [
            'student_name' => 'Siswa Penguji',
            'jam_pulang' => '16:00',
            'titik_kumpul' => 'Gerbang Utama Wikrama',
            'tujuan' => 'Pasar Cisarua',
        ]);

        $response->assertRedirect(route('pulang.index'));
        $this->assertDatabaseHas('pulang_barengs', [
            'student_name' => 'Siswa Penguji',
            'jam_pulang' => '16:00',
        ]);

        // Post traffic comment
        $commentResponse = $this->post(route('pulang.comment'), [
            'author_name' => 'Pelapor Jalan',
            'traffic_status' => 'Lancar',
            'comment' => 'Tajur lancar jaya sore ini.',
        ]);

        $commentResponse->assertRedirect(route('pulang.index'));
        $this->assertDatabaseHas('pulang_comments', [
            'author_name' => 'Pelapor Jalan',
            'traffic_status' => 'Lancar',
        ]);
    }

    public function test_bk_anonymous_curhat_submission(): void
    {
        $response = $this->post(route('bk.curhat.store'), [
            'title' => 'Pertanyaan Rahasia Karakter',
            'category' => 'Akademik & Piket',
            'content' => 'Bagaimana tips disiplin belajar?',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('bk_posts', [
            'type' => 'CURHAT_ANONIM',
            'title' => 'Pertanyaan Rahasia Karakter',
            'author' => 'Siswa Anonim (Cisarua 7)',
        ]);
    }

    public function test_photocopy_catalog_renders_price_list(): void
    {
        $response = $this->get(route('photocopy.index'));

        $response->assertStatus(200);
        $response->assertSee('Barokah Jaya');
        $response->assertSee('Digital Print Fast');
        $response->assertSee('Wikrama Mart');
        $response->assertSee('Fotokopi Hitam Putih (B/W)');
    }
}
