<?php

namespace Database\Seeders;

use App\Models\BkPost;
use App\Models\Member;
use App\Models\Photocopy;
use App\Models\PiketLog;
use App\Models\PulangBareng;
use App\Models\PulangComment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Users Initialization
        User::updateOrCreate(
            ['email' => 'admin@rayon.com'],
            [
                'name' => 'Pengurus Rayon Cisarua 7',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'siswa@rayon.com'],
            [
                'name' => 'Siswa Cisarua 7 #1',
                'password' => Hash::make('password123'),
                'role' => 'siswa',
            ]
        );

        // 2. Members Initialization (45 Anggota)
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $today = Carbon::today()->format('Y-m-d');

        for ($i = 1; $i <= 45; $i++) {
            $nis = (string) (12100000 + $i);
            $dayIndex = (int) floor(($i - 1) / 9);
            $piketDay = $days[$dayIndex] ?? 'Jumat';
            $isPkl = ($i >= 37 && $i <= 45);

            // Give sample active sanctions to Siswa #4 and Siswa #12
            $sanctionActive = ($i === 4 || $i === 12);
            $sanctionUntil = $sanctionActive ? Carbon::today()->addDays(5)->format('Y-m-d') : null;

            $member = Member::updateOrCreate(
                ['nis' => $nis],
                [
                    'name' => "Siswa Cisarua 7 #{$i}",
                    'piket_day' => $piketDay,
                    'is_pkl' => $isPkl,
                    'sanction_active' => $sanctionActive,
                    'sanction_until' => $sanctionUntil,
                ]
            );

            // Sample Piket Logs for today
            if ($isPkl) {
                PiketLog::updateOrCreate(
                    ['member_id' => $member->id, 'date' => $today],
                    ['status' => 'PKL', 'notes' => 'Sedang melaksanakan Praktek Kerja Lapangan di Industri mitra']
                );
            } elseif ($i === 4 || $i === 12) {
                PiketLog::updateOrCreate(
                    ['member_id' => $member->id, 'date' => $today],
                    ['status' => 'Alpa', 'notes' => 'Tidak hadir tanpa keterangan. Dikenai sanksi piket 7 hari berturut-turut.']
                );
            } elseif ($i % 7 === 0) {
                PiketLog::updateOrCreate(
                    ['member_id' => $member->id, 'date' => $today],
                    ['status' => 'Izin', 'notes' => 'Dispensasi perwakilan lomba kompetensi siswa']
                );
            } elseif ($i % 11 === 0) {
                PiketLog::updateOrCreate(
                    ['member_id' => $member->id, 'date' => $today],
                    ['status' => 'Sakit', 'notes' => 'Surat dokter terlampir di ruang rayon']
                );
            } else {
                PiketLog::updateOrCreate(
                    ['member_id' => $member->id, 'date' => $today],
                    ['status' => 'Hadir', 'notes' => 'Hadir tepat waktu dan menyelesaikan piket area rayon']
                );
            }
        }

        // 3. Ruang Pulang Bareng
        $siswaUser = User::where('email', 'siswa@rayon.com')->first();
        PulangBareng::create([
            'user_id' => $siswaUser?->id,
            'student_name' => 'Siswa Cisarua 7 #1',
            'date' => $today,
            'jam_pulang' => '16:00',
            'titik_kumpul' => 'Gerbang Utama Wikrama',
            'tujuan' => 'Cisarua Atas (Pasar Cisarua)',
        ]);

        PulangBareng::create([
            'user_id' => null,
            'student_name' => 'Siswa Cisarua 7 #10',
            'date' => $today,
            'jam_pulang' => '16:00',
            'titik_kumpul' => 'Halte Bus Kuntum',
            'tujuan' => 'Megamendung (Cipayung)',
        ]);

        PulangBareng::create([
            'user_id' => null,
            'student_name' => 'Siswa Cisarua 7 #22',
            'date' => $today,
            'jam_pulang' => '16:00',
            'titik_kumpul' => 'Gerbang Utama Wikrama',
            'tujuan' => 'Cisarua (Tugu Selatan)',
        ]);

        PulangBareng::create([
            'user_id' => null,
            'student_name' => 'Siswa Cisarua 7 #2',
            'date' => $today,
            'jam_pulang' => '17:30',
            'titik_kumpul' => 'Simpang Lampu Merah Tajur',
            'tujuan' => 'Ciawi - Gadog',
        ]);

        PulangBareng::create([
            'user_id' => null,
            'student_name' => 'Siswa Cisarua 7 #15',
            'date' => $today,
            'jam_pulang' => '17:30',
            'titik_kumpul' => 'Gerbang Wikrama',
            'tujuan' => 'Megamendung (Gadog)',
        ]);

        PulangBareng::create([
            'user_id' => null,
            'student_name' => 'Siswa Cisarua 7 #30',
            'date' => $today,
            'jam_pulang' => '17:30',
            'titik_kumpul' => 'Gerbang Wikrama',
            'tujuan' => 'Cisarua (Simpang Citeko)',
        ]);

        // 4. Diskusi Lalu Lintas & Angkot
        PulangComment::create([
            'author_name' => 'Faisal (Pengurus Piket)',
            'traffic_status' => 'Padat',
            'date' => $today,
            'comment' => 'Info rute: Tajur arah Ciawi padat di sekitar Ramayana Tajur karena antrean angkot ngetem. Rombongan 16:00 kumpul tepat waktu ya.',
        ]);

        PulangComment::create([
            'author_name' => 'Panji (Rayon Cis 7)',
            'traffic_status' => 'Lancar',
            'date' => $today,
            'comment' => 'Selepas simpang Ciawi ke arah Gadog terpantau lancar jaya, belum ada tanda-tanda one-way.',
        ]);

        PulangComment::create([
            'author_name' => 'Fathir',
            'traffic_status' => 'One Way',
            'date' => $today,
            'comment' => 'Info dari polantas Ciawi: Jalur Puncak normal 2 arah untuk sore ini. Angkot 02A biru banyak di simpang Ciawi.',
        ]);

        // 5. Bimbingan Konseling Posts
        BkPost::create([
            'type' => 'ARTICLE',
            'title' => 'Strategi Manajemen Waktu: Keseimbangan Tugas Kejuruan & Kedisiplinan Piket',
            'content' => 'Di SMK Wikrama, kedisiplinan dan tanggung jawab adalah nilai utama. Siswa yang mampu membagi waktu antara penuntasan projek kejuruan, piket kebersihan rayon, dan istirahat berkualitas akan terbentuk menjadi pribadi profesional yang siap kerja. Jangan menunda tugas piket, jadikan tanggung jawab ini sebagai latihan integritas harian!',
            'author' => 'Ibu Dra. Hj. Ratna, M.Pd (Guru BK)',
            'category' => 'Tips Belajar & Karakter',
            'status' => 'Dipublikasikan',
        ]);

        BkPost::create([
            'type' => 'ARTICLE',
            'title' => 'Mengenali Burnout & Menjaga Kesehatan Mental Remaja',
            'content' => 'Tuntutan deadline sertifikasi kejuruan terkadang memicu stres pada siswa. Kenali tanda-tanda kelelahan mental: susah tidur, hilangnya motivasi, dan mudah cemas. Bicarakan kendala dengan Guru BK atau teman sejawat di rayon. Ruang BK selalu terbuka untuk kalian tanpa penghakiman.',
            'author' => 'Ibu Dra. Hj. Ratna, M.Pd (Guru BK)',
            'category' => 'Kesehatan Mental',
            'status' => 'Dipublikasikan',
        ]);

        BkPost::create([
            'type' => 'ARTICLE',
            'title' => 'Panduan Parenting: Komunikasi Positif Orang Tua & Anak Menjelang PKL',
            'content' => 'Memasuki masa Praktek Kerja Lapangan (PKL), siswa membutuhkan dukungan mental yang kokoh dari lingkungan rumah. Orang tua diharapkan dapat memberikan apresiasi dan ruang diskusi terbuka mengenai pengalaman harian anak di industri, serta memantau kesehatan fisik putra-putrinya.',
            'author' => 'Ibu Dra. Hj. Ratna, M.Pd (Guru BK)',
            'category' => 'Parenting',
            'status' => 'Dipublikasikan',
        ]);

        // 6. Tempat Fotokopi Sekitar
        Photocopy::create([
            'name' => 'Fotokopi Barokah Jaya Wikrama',
            'distance' => '150 meter dari gerbang Wikrama',
            'hours' => '06:00 - 21:00 WIB',
            'map_url' => 'https://maps.google.com/?q=Fotokopi+Barokah+Jaya+Sindangsari+Bogor',
            'price_list' => [
                ['service' => 'Fotokopi Hitam Putih (B/W)', 'price' => 'Rp 250 / lembar', 'note' => 'Kertas 75gsm A4/F4'],
                ['service' => 'Print Hitam Putih', 'price' => 'Rp 500 / lembar', 'note' => 'Cocok untuk laporan & modul'],
                ['service' => 'Print Warna', 'price' => 'Rp 1.000 / lembar', 'note' => 'Kualitas tajam inkjet'],
                ['service' => 'Jilid Lakban Biasa', 'price' => 'Rp 3.000 / buku', 'note' => 'Termasuk mika transparan'],
                ['service' => 'Jilid Spiral Plastik', 'price' => 'Rp 8.000 / buku', 'note' => 'Rapi untuk portofolio'],
                ['service' => 'Laminating Pres', 'price' => 'Rp 4.000 / lembar', 'note' => 'Tahan air & rapi'],
            ],
        ]);

        Photocopy::create([
            'name' => 'Digital Print Fast Tajur',
            'distance' => '400 meter dari SMK Wikrama',
            'hours' => '07:00 - 22:00 WIB',
            'map_url' => 'https://maps.google.com/?q=Digital+Print+Fast+Tajur+Bogor',
            'price_list' => [
                ['service' => 'Fotokopi Hitam Putih', 'price' => 'Rp 300 / lembar', 'note' => 'Kecepatan tinggi mesin laser'],
                ['service' => 'Print Warna Glossy/Art Paper', 'price' => 'Rp 2.000 / lembar', 'note' => 'Kertas tebal 150gsm'],
                ['service' => 'Jilid Hardcover / Skripsi', 'price' => 'Rp 25.000 / buku', 'note' => 'Emboss foil emas'],
                ['service' => 'Jilid Softcover Mika', 'price' => 'Rp 5.000 / buku', 'note' => 'Paling laris untuk tugas siswa'],
                ['service' => 'Print Poster / Infografis A3', 'price' => 'Rp 6.000 / lembar', 'note' => 'Bahan art karton'],
            ],
        ]);

        Photocopy::create([
            'name' => 'Wikrama Mart & Student Copy Center',
            'distance' => '0 meter (Area Dalam Sekolah Wikrama)',
            'hours' => '06:45 - 16:30 WIB',
            'map_url' => 'https://maps.google.com/?q=SMK+Wikrama+Bogor',
            'price_list' => [
                ['service' => 'Fotokopi Hitam Putih Khusus Siswa', 'price' => 'Rp 200 / lembar', 'note' => 'Subsidi pelajar Wikrama'],
                ['service' => 'Print Dokumen Tugas', 'price' => 'Rp 500 / lembar', 'note' => 'Langsung dari flashdisk/HP'],
                ['service' => 'Print Warna Dokumen', 'price' => 'Rp 800 / lembar', 'note' => 'Hemat khusus tugas'],
                ['service' => 'Jilid Mika Sederhana', 'price' => 'Rp 2.500 / buku', 'note' => 'Praktis untuk lembar kerja'],
                ['service' => 'Kertas Folio Bergaris', 'price' => 'Rp 500 / 2 lembar', 'note' => 'Sedia di kasir'],
            ],
        ]);
    }
}
