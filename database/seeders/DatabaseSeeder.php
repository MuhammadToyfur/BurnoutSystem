<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DiagnosisRule;
use App\Models\User;
use App\Models\Article;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder tambahan
        $this->call(ArticlePencegahanSeeder::class);

        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@burnout.ac.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Demo mahasiswa
        User::updateOrCreate(
            ['email' => 'budi@mahasiswa.ac.id'],
            [
                'name' => 'Budi Santoso',
                'nim' => '2021001001',
                'jurusan' => 'Teknik Informatika',
                'angkatan' => '2021',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
            ]
        );

        $rules = [
            // ===== RISIKO TINGGI =====
            [
                'rule_code' => 'R01',
                'kondisi' => 'Beban tugas sangat tinggi DAN kualitas tidur sangat buruk DAN motivasi sangat rendah',
                'kondisi_json' => [
                    ['variabel' => 'beban_tugas', 'operator' => '>=', 'nilai' => 4],
                    ['variabel' => 'tidur', 'operator' => '<=', 'nilai' => 2],
                    ['variabel' => 'motivasi', 'operator' => '<=', 'nilai' => 2],
                ],
                'hasil_risiko' => 'Tinggi',
                'certainty_factor' => 0.95,
                'rekomendasi' => 'Kondisi Anda sangat mengkhawatirkan. Segera konsultasikan dengan konselor atau psikolog kampus. Prioritaskan istirahat, kurangi beban tugas secara bertahap, dan cari dukungan dari keluarga atau teman dekat.',
                'bobot' => 10,
            ],
            [
                'rule_code' => 'R02',
                'kondisi' => 'Kelelahan emosi tinggi DAN depersonalisasi tinggi DAN prestasi akademik sangat rendah',
                'kondisi_json' => [
                    ['variabel' => 'emosi', 'operator' => '<=', 'nilai' => 2],
                    ['variabel' => 'sosial', 'operator' => '<=', 'nilai' => 2],
                    ['variabel' => 'prestasi', 'operator' => '<=', 'nilai' => 2],
                ],
                'hasil_risiko' => 'Tinggi',
                'certainty_factor' => 0.92,
                'rekomendasi' => 'Tanda-tanda burnout berat terdeteksi. Anda perlu segera mendapat bantuan profesional. Cuti akademik bisa menjadi pilihan untuk pemulihan. Jangan menanggung beban ini sendiri.',
                'bobot' => 10,
            ],
            [
                'rule_code' => 'R03',
                'kondisi' => 'Lima atau lebih variabel berada pada level kritis (≤2)',
                'kondisi_json' => [
                    ['tipe' => 'count_critical', 'threshold' => 5, 'level' => 2],
                ],
                'hasil_risiko' => 'Tinggi',
                'certainty_factor' => 0.88,
                'rekomendasi' => 'Multiple dimensi burnout terdeteksi secara bersamaan. Ini merupakan kondisi burnout komprehensif yang membutuhkan intervensi segera dari tenaga profesional kesehatan mental.',
                'bobot' => 9,
            ],
            [
                'rule_code' => 'R04',
                'kondisi' => 'Beban tugas ekstrem DAN tekanan keuangan tinggi DAN kecemasan masa depan tinggi',
                'kondisi_json' => [
                    ['variabel' => 'beban_tugas', 'operator' => '>=', 'nilai' => 5],
                    ['variabel' => 'keuangan', 'operator' => '<=', 'nilai' => 2],
                    ['variabel' => 'masa_depan', 'operator' => '<=', 'nilai' => 2],
                ],
                'hasil_risiko' => 'Tinggi',
                'certainty_factor' => 0.85,
                'rekomendasi' => 'Tekanan multi-dimensi (akademik, keuangan, dan kecemasan masa depan) menyebabkan burnout serius. Pertimbangkan untuk mencari beasiswa, bimbingan karir, dan dukungan psikologis segera.',
                'bobot' => 9,
            ],
            [
                'rule_code' => 'R05',
                'kondisi' => 'Kondisi fisik sangat buruk DAN kualitas tidur sangat buruk DAN emosi tidak stabil',
                'kondisi_json' => [
                    ['variabel' => 'fisik', 'operator' => '<=', 'nilai' => 2],
                    ['variabel' => 'tidur', 'operator' => '<=', 'nilai' => 2],
                    ['variabel' => 'emosi', 'operator' => '<=', 'nilai' => 2],
                ],
                'hasil_risiko' => 'Tinggi',
                'certainty_factor' => 0.90,
                'rekomendasi' => 'Burnout fisik and emosional yang berat. Segera periksakan ke dokter dan konselor. Istirahat total sementara waktu sangat diperlukan untuk pemulihan.',
                'bobot' => 9,
            ],
 
            // ===== RISIKO SEDANG =====
            [
                'rule_code' => 'R06',
                'kondisi' => 'Beban tugas tinggi DAN manajemen waktu buruk DAN motivasi rendah',
                'kondisi_json' => [
                    ['variabel' => 'beban_tugas', 'operator' => '>=', 'nilai' => 4],
                    ['variabel' => 'waktu', 'operator' => '<=', 'nilai' => 2],
                    ['variabel' => 'motivasi', 'operator' => '<=', 'nilai' => 3],
                ],
                'hasil_risiko' => 'Sedang',
                'certainty_factor' => 0.65,
                'rekomendasi' => 'Anda berisiko burnout sedang. Perbaiki manajemen waktu dengan teknik Pomodoro atau time-blocking. Bagi tugas besar menjadi bagian kecil. Temukan kembali motivasi intrinsik Anda.',
                'bobot' => 6,
            ],
            [
                'rule_code' => 'R07',
                'kondisi' => 'Kualitas tidur buruk DAN kondisi fisik kurang baik DAN prestasi kurang memuaskan',
                'kondisi_json' => [
                    ['variabel' => 'tidur', 'operator' => '<=', 'nilai' => 3],
                    ['variabel' => 'fisik', 'operator' => '<=', 'nilai' => 3],
                    ['variabel' => 'prestasi', 'operator' => '<=', 'nilai' => 3],
                ],
                'hasil_risiko' => 'Sedang',
                'certainty_factor' => 0.60,
                'rekomendasi' => 'Pola tidur dan kondisi fisik memengaruhi prestasi akademik. Targetkan 7-8 jam tidur per malam, olahraga ringan 30 menit/hari, dan atur pola makan bergizi.',
                'bobot' => 6,
            ],
            [
                'rule_code' => 'R08',
                'kondisi' => 'Dukungan sosial rendah DAN emosi kurang stabil DAN kecemasan masa depan tinggi',
                'kondisi_json' => [
                    ['variabel' => 'sosial', 'operator' => '<=', 'nilai' => 3],
                    ['variabel' => 'emosi', 'operator' => '<=', 'nilai' => 3],
                    ['variabel' => 'masa_depan', 'operator' => '<=', 'nilai' => 3],
                ],
                'hasil_risiko' => 'Sedang',
                'certainty_factor' => 0.55,
                'rekomendasi' => 'Isolasi sosial dan kecemasan dapat memperburuk burnout. Bergabunglah dengan komunitas kampus, ikuti kegiatan ekstrakurikuler, dan pertimbangkan konseling untuk mengatasi kecemasan.',
                'bobot' => 6,
            ],
            [
                'rule_code' => 'R09',
                'kondisi' => 'Tiga atau empat variabel berada pada level kurang baik (≤3)',
                'kondisi_json' => [
                    ['tipe' => 'count_critical', 'threshold' => 3, 'level' => 3, 'max' => 4],
                ],
                'hasil_risiko' => 'Sedang',
                'certainty_factor' => 0.50,
                'rekomendasi' => 'Beberapa aspek kehidupan akademik Anda perlu perhatian. Identifikasi area yang paling mengganggu dan fokus perbaiki satu per satu. Diskusikan dengan dosen pembimbing akademik.',
                'bobot' => 5,
            ],
            [
                'rule_code' => 'R10',
                'kondisi' => 'Tekanan keuangan cukup tinggi DAN manajemen waktu kurang baik',
                'kondisi_json' => [
                    ['variabel' => 'keuangan', 'operator' => '<=', 'nilai' => 3],
                    ['variabel' => 'waktu', 'operator' => '<=', 'nilai' => 3],
                ],
                'hasil_risiko' => 'Sedang',
                'certainty_factor' => 0.45,
                'rekomendasi' => 'Tekanan keuangan dan waktu bisa memicu burnout. Cari informasi beasiswa, part-time yang fleksibel, dan gunakan aplikasi manajemen waktu untuk mengatur prioritas.',
                'bobot' => 5,
            ],
 
            // ===== RISIKO RENDAH =====
            [
                'rule_code' => 'R11',
                'kondisi' => 'Semua variabel berada pada level baik hingga sangat baik (≥4)',
                'kondisi_json' => [
                    ['tipe' => 'all_good', 'level' => 4],
                ],
                'hasil_risiko' => 'Rendah',
                'certainty_factor' => 0.95,
                'rekomendasi' => 'Kondisi Anda sangat baik! Pertahankan gaya hidup sehat ini. Tetap jaga keseimbangan antara studi, istirahat, dan kehidupan sosial. Jadilah inspirasi bagi teman-teman sekitar Anda.',
                'bobot' => 1,
            ],
            [
                'rule_code' => 'R12',
                'kondisi' => 'Tidak lebih dari dua variabel pada level cukup, sisanya baik',
                'kondisi_json' => [
                    ['tipe' => 'count_critical', 'threshold' => 0, 'level' => 3, 'max' => 2],
                ],
                'hasil_risiko' => 'Rendah',
                'certainty_factor' => 0.85,
                'rekomendasi' => 'Risiko burnout Anda rendah. Ada beberapa area kecil yang bisa ditingkatkan, namun secara keseluruhan kondisi Anda cukup sehat. Tetap waspada dan lakukan self-check secara berkala.',
                'bobot' => 2,
            ],
            [
                'rule_code' => 'R13',
                'kondisi' => 'Motivasi tinggi DAN dukungan sosial baik DAN manajemen waktu baik',
                'kondisi_json' => [
                    ['variabel' => 'motivasi', 'operator' => '>=', 'nilai' => 4],
                    ['variabel' => 'sosial', 'operator' => '>=', 'nilai' => 4],
                    ['variabel' => 'waktu', 'operator' => '>=', 'nilai' => 4],
                ],
                'hasil_risiko' => 'Rendah',
                'certainty_factor' => 0.80,
                'rekomendasi' => 'Tiga pilar penting (motivasi, sosial, dan waktu) Anda sangat baik. Ini adalah fondasi kuat untuk menghindari burnout. Terus kembangkan skill dan jaringan pertemanan Anda.',
                'bobot' => 2,
            ],
        ];

        foreach ($rules as $rule) {
            DiagnosisRule::updateOrCreate(
                ['rule_code' => $rule['rule_code']],
                $rule
            );
        }

        // Artikel edukasi
        $articles = [
            [
                'judul' => 'Apa Itu Burnout? Kenali Tanda-tandanya',
                'slug' => 'apa-itu-burnout-kenali-tanda-tandanya',
                'konten' => 'Burnout adalah kondisi kelelahan fisik, emosional, dan mental yang disebabkan oleh stres berkepanjangan. Berbeda dengan stres biasa, burnout adalah kondisi kronis yang mempengaruhi seluruh aspek kehidupan. Tanda-tanda burnout meliputi: kelelahan ekstrem, sinisme terhadap pekerjaan/studi, penurunan produktivitas, perasaan tidak efektif, dan penarikan diri dari lingkungan sosial. Burnout pada mahasiswa sering dipicu oleh beban akademik yang berlebihan, kurang tidur, kurangnya dukungan sosial, dan tekanan dari berbagai pihak. Mengenali burnout sejak dini sangat penting untuk mencegah dampak yang lebih serius pada kesehatan mental dan akademik.',
                'kategori' => 'info',
                'published' => true,
                'author_id' => 1,
                'source_name' => 'World Psychiatry (Wiley Online Library)',
                'source_url' => 'https://onlinelibrary.wiley.com/doi/full/10.1002/wps.20311',
            ],
            [
                'judul' => '7 Cara Efektif Mencegah Burnout Mahasiswa',
                'slug' => '7-cara-efektif-mencegah-burnout-mahasiswa',
                'konten' => '1. Kelola Waktu dengan Baik: Gunakan teknik Pomodoro (25 menit fokus, 5 menit istirahat) untuk meningkatkan produktivitas tanpa kelelahan. 2. Prioritaskan Tidur: Tidur 7-8 jam per malam bukan kemewahan, melainkan kebutuhan untuk fungsi kognitif optimal. 3. Olahraga Teratur: 30 menit olahraga ringan per hari terbukti mengurangi stres and meningkatkan mood. 4. Jaga Koneksi Sosial: Luangkan waktu untuk bersosialisasi dengan teman dan keluarga. 5. Tetapkan Batasan: Belajar untuk mengatakan tidak pada komitmen berlebihan. 6. Praktikkan Mindfulness: Meditasi 10-15 menit per hari dapat mengurangi kecemasan secara signifikan. 7. Cari Bantuan Profesional: Tidak ada salahnya berkonsultasi dengan konselor atau psikolog kampus.',
                'kategori' => 'tips',
                'published' => true,
                'author_id' => 1,
                'source_name' => 'NIH / PubMed Central',
                'source_url' => 'https://www.ncbi.nlm.nih.gov/pmc/articles/PMC8472814/',
            ],
            [
                'judul' => 'Manajemen Stres Akademik: Panduan Praktis',
                'slug' => 'manajemen-stres-akademik-panduan-praktis',
                'konten' => 'Stres akademik adalah bagian tak terpisahkan dari kehidupan mahasiswa. Namun, stres yang tidak dikelola dapat berkembang menjadi burnout. Berikut strategi manajemen stres yang terbukti efektif: Identifikasi Sumber Stres - Tuliskan semua hal yang membuat Anda stres dan kategorikan berdasarkan prioritas dan urgensi. Teknik Pernapasan - Latihan pernapasan 4-7-8 (hirup 4 detik, tahan 7 detik, hembuskan 8 detik) efektif menenangkan sistem saraf. Journaling - Menulis jurnal harian membantu memproses emosi dan mendapatkan perspektif baru. Study Group - Belajar bersama teman dapat meringankan beban dan meningkatkan pemahaman. Batas Digital - Batasi penggunaan media sosial terutama menjelang tidur untuk kualitas istirahat yang lebih baik.',
                'kategori' => 'tips',
                'published' => true,
                'author_id' => 1,
                'source_name' => 'NIH / PubMed Central',
                'source_url' => 'https://www.ncbi.nlm.nih.gov/pmc/articles/PMC7491717/',
            ],
        ];

        foreach ($articles as $article) {
            Article::updateOrCreate(
                ['slug' => $article['slug']],
                $article
            );
        }
    }
}
