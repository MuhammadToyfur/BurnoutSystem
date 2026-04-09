<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\User;

class ArticlePencegahanSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = User::where('role', 'admin')->first()?->id ?? 1;

        $articles = [
            [
                'judul' => 'Strategi Pencegahan Burnout Sebelum Terlambat',
                'slug' => 'strategi-pencegahan-burnout-sebelum-terlambat',
                'konten' => "Mencegah burnout jauh lebih mudah daripada mengobatinya. Berikut strategi pencegahan yang telah terbukti efektif secara ilmiah:\n\n1. Kenali Batas Diri\nSetiap orang memiliki kapasitas yang berbeda. Belajar mengenali sinyal tubuh saat mulai kelelahan adalah langkah pertama pencegahan. Jangan tunggu sampai Anda benar-benar jatuh untuk mulai istirahat.\n\n2. Jadwalkan Waktu Pemulihan\nSama seperti otot yang butuh istirahat setelah berolahraga, otak Anda juga butuh waktu memulihkan diri. Sisipkan jeda istirahat di antara sesi belajar.\n\n3. Bangun Rutinitas Pagi yang Positif\nMemulai hari dengan aktivitas positif seperti olahraga ringan, meditasi, atau membaca selama 15-30 menit dapat meningkatkan ketahanan mental Anda sepanjang hari.\n\n4. Tetap Terhubung dengan Tujuan\nIngat kembali alasan awal Anda memilih jurusan ini. Menemukan kembali makna dalam studi Anda adalah salah satu perlindungan terkuat dari burnout.\n\n5. Evaluasi Mingguan\nLuangkan 10 menit setiap Minggu malam untuk mengevaluasi minggu yang baru lewat dan merencanakan minggu depan. Ini membantu Anda tetap dalam kendali.",
                'kategori' => 'pencegahan',
                'published' => true,
                'author_id' => $adminId,
                'source_name' => 'Int. J. Environ. Res. Public Health (NCBI)',
                'source_url' => 'https://www.ncbi.nlm.nih.gov/pmc/articles/PMC8834718/',
            ],
            [
                'judul' => 'Pola Hidup Sehat untuk Mencegah Burnout Akademik',
                'slug' => 'pola-hidup-sehat-untuk-mencegah-burnout-akademik',
                'konten' => "Kesehatan fisik dan mental adalah fondasi utama performa akademik. Pola hidup sehat yang konsisten dapat menjadi perisai terkuat melawan burnout.\n\nTidur Berkualitas\nKurang tidur bukan tanda kerja keras, melainkan tanda manajemen waktu yang buruk. Tidur cukup 7-9 jam meningkatkan konsentrasi, daya ingat, dan regulasi emosi.\n\nNutrisi yang Tepat\nOtak Anda membutuhkan bahan bakar yang tepat. Konsumsi makanan bergizi, perbanyak sayur dan buah, kurangi kafein berlebihan dan makanan olahan.\n\nOlahraga Rutin\nPenelitian menunjukkan olahraga aerobik 30 menit sebanyak 3-4 kali seminggu dapat mengurangi gejala kecemasan dan depresi secara signifikan.\n\nManajemen Kafein\nBanyak mahasiswa mengandalkan kopi untuk tetap terjaga. Batasi konsumsi kafein maksimal 400mg per hari (sekitar 3 cangkir kopi) dan hindari setelah pukul 15.00.\n\nHealing Activities\nSisipkan kegiatan yang benar-benar Anda nikmati setiap hari — mendengarkan musik favorit, bermain game sebentar, atau menonton episode serial. Ini bukan membuang waktu, tetapi investasi kesehatan mental.",
                'kategori' => 'pencegahan',
                'published' => true,
                'author_id' => $adminId,
                'source_name' => 'Journal of Clinical Medicine (NCBI)',
                'source_url' => 'https://www.ncbi.nlm.nih.gov/pmc/articles/PMC8231548/',
            ],
            [
                'judul' => 'Membangun Sistem Dukungan Sosial yang Kuat',
                'slug' => 'membangun-sistem-dukungan-sosial-yang-kuat',
                'konten' => "Isolasi sosial adalah salah satu faktor risiko burnout terbesar. Memiliki jaringan dukungan yang kuat dapat menjadi penyangga yang melindungi Anda dari efek negatif stres akademik.\n\nMengapa Dukungan Sosial Penting?\nStudi menunjukkan bahwa mahasiswa dengan jaringan sosial yang kuat memiliki risiko burnout 60% lebih rendah dibandingkan yang terisolasi.\n\nCara Membangun Sistem Dukungan:\n- Bergabung dengan kelompok belajar\n- Aktif di satu atau dua organisasi kampus yang Anda minati\n- Jaga hubungan dengan keluarga minimal seminggu sekali\n- Manfaatkan layanan konseling dan psikolog kampus\n- Cari mentor dari senior atau dosen\n\nIngat: Meminta bantuan adalah tanda kekuatan, bukan kelemahan.",
                'kategori' => 'pencegahan',
                'published' => true,
                'author_id' => $adminId,
                'source_name' => 'Frontiers in Psychology (NCBI)',
                'source_url' => 'https://www.ncbi.nlm.nih.gov/pmc/articles/PMC6488734/',
            ],
            [
                'judul' => 'Teknik Mindfulness untuk Mahasiswa: Cegah Burnout dari Dalam',
                'slug' => 'teknik-mindfulness-untuk-mahasiswa-cegah-burnout',
                'konten' => "Mindfulness atau kesadaran penuh telah terbukti secara ilmiah sebagai salah satu metode paling efektif dalam pencegahan burnout.\n\nApa itu Mindfulness?\nMindfulness adalah kemampuan untuk hadir sepenuhnya di momen saat ini, tanpa menghakimi. Bukan berarti mengosongkan pikiran, tetapi mengamati pikiran dan perasaan tanpa terbawa.\n\nTeknik Dasar:\n\n1. Pernapasan 4-7-8\nHirup selama 4 detik, tahan 7 detik, hembuskan 8 detik. Lakukan 3-4 siklus saat merasa tegang.\n\n2. Body Scan\nDuduklah tenang selama 10 menit dan perhatikan sensasi di setiap bagian tubuh dari kaki hingga kepala.\n\n3. Mindful Study\nSaat belajar, matikan notifikasi dan fokus penuh pada satu tugas. Setiap 25 menit, istirahat 5 menit (teknik Pomodoro).\n\n4. Journaling Harian\nTulis 3 hal yang Anda syukuri setiap malam. Ini secara terbukti meningkatkan kesejahteraan mental dalam 4 minggu.\n\nMulai dengan 5-10 menit per hari dan tingkatkan secara bertahap.",
                'kategori' => 'pencegahan',
                'published' => true,
                'author_id' => $adminId,
                'source_name' => 'Journal of American College Health (PubMed)',
                'source_url' => 'https://pubmed.ncbi.nlm.nih.gov/31166863/',
            ],
        ];

        foreach ($articles as $data) {
            Article::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }

        $this->command->info('✅ Artikel pencegahan berhasil ditambahkan/diperbarui: ' . count($articles) . ' artikel.');
    }
}
