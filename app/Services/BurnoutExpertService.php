<?php

namespace App\Services;

use App\Models\DiagnosisRule;
use App\Models\DiagnosisSession;
use Illuminate\Support\Facades\Auth;

/**
 * Sistem Berbasis Pengetahuan (SBP) - Mesin Inferensi Burnout Mahasiswa
 * 
 * Metode: Forward Chaining dengan Rule-Based System
 * Variabel Input (10): beban_tugas, tidur, motivasi, sosial, fisik,
 *                      keuangan, emosi, prestasi, waktu, masa_depan
 * Skala: 1 (sangat buruk) - 5 (sangat baik)
 * Output: Risiko Rendah / Sedang / Tinggi
 */
class BurnoutExpertService
{
    // Definisi variabel SBP
    public static array $variabel = [
        'beban_tugas' => [
            'label' => 'Beban Tugas Kuliah',
            'pertanyaan' => 'Bagaimana tingkat beban tugas dan tanggung jawab akademik Anda saat ini?',
            'opsi' => [
                1 => 'Sangat berat - hampir tidak tertangani',
                2 => 'Berat - sering kewalahan',
                3 => 'Cukup berat - masih bisa ditangani',
                4 => 'Ringan - mudah dikelola',
                5 => 'Sangat ringan - tidak ada tekanan',
            ],
            'dimensi' => 'kelelahan',
            'bobot_sbp' => 1.2,
        ],
        'tidur' => [
            'label' => 'Kualitas & Kuantitas Tidur',
            'pertanyaan' => 'Bagaimana kualitas dan kuantitas tidur Anda dalam 2 minggu terakhir?',
            'opsi' => [
                1 => 'Sangat buruk - < 4 jam, sering insomnia',
                2 => 'Buruk - 4-5 jam, sering terganggu',
                3 => 'Cukup - 5-6 jam, kadang terganggu',
                4 => 'Baik - 6-7 jam, cukup nyenyak',
                5 => 'Sangat baik - 7-8 jam, nyenyak',
            ],
            'dimensi' => 'kelelahan',
            'bobot_sbp' => 1.3,
        ],
        'motivasi' => [
            'label' => 'Motivasi Belajar',
            'pertanyaan' => 'Seberapa besar motivasi Anda untuk belajar dan mengikuti perkuliahan?',
            'opsi' => [
                1 => 'Sangat rendah - tidak ada semangat sama sekali',
                2 => 'Rendah - jarang merasa termotivasi',
                3 => 'Cukup - motivasi naik turun',
                4 => 'Tinggi - sering merasa termotivasi',
                5 => 'Sangat tinggi - selalu semangat belajar',
            ],
            'dimensi' => 'prestasi',
            'bobot_sbp' => 1.1,
        ],
        'sosial' => [
            'label' => 'Dukungan Sosial',
            'pertanyaan' => 'Bagaimana kualitas hubungan sosial dan dukungan dari orang sekitar Anda?',
            'opsi' => [
                1 => 'Sangat buruk - terisolasi, tidak ada dukungan',
                2 => 'Buruk - hubungan renggang, sedikit dukungan',
                3 => 'Cukup - ada beberapa teman/keluarga yang mendukung',
                4 => 'Baik - punya jaringan sosial yang baik',
                5 => 'Sangat baik - dukungan penuh dari keluarga dan teman',
            ],
            'dimensi' => 'depersonalisasi',
            'bobot_sbp' => 1.0,
        ],
        'fisik' => [
            'label' => 'Kondisi Fisik & Kesehatan',
            'pertanyaan' => 'Bagaimana kondisi fisik dan kesehatan Anda secara keseluruhan?',
            'opsi' => [
                1 => 'Sangat buruk - sering sakit, kelelahan ekstrem',
                2 => 'Buruk - mudah sakit, energi rendah',
                3 => 'Cukup - sesekali sakit, energi cukup',
                4 => 'Baik - jarang sakit, energi cukup baik',
                5 => 'Sangat baik - sehat dan penuh energi',
            ],
            'dimensi' => 'kelelahan',
            'bobot_sbp' => 1.1,
        ],
        'keuangan' => [
            'label' => 'Tekanan Keuangan',
            'pertanyaan' => 'Seberapa besar tekanan keuangan yang Anda rasakan?',
            'opsi' => [
                1 => 'Sangat besar - tidak bisa memenuhi kebutuhan dasar',
                2 => 'Besar - sering khawatir tentang keuangan',
                3 => 'Sedang - kadang ada tekanan keuangan',
                4 => 'Kecil - keuangan cukup stabil',
                5 => 'Tidak ada - keuangan aman dan tercukupi',
            ],
            'dimensi' => 'kelelahan',
            'bobot_sbp' => 0.9,
        ],
        'emosi' => [
            'label' => 'Kestabilan Emosi',
            'pertanyaan' => 'Bagaimana kondisi emosi Anda dalam kehidupan sehari-hari?',
            'opsi' => [
                1 => 'Sangat tidak stabil - mudah marah, cemas, depresi',
                2 => 'Tidak stabil - emosi sering berfluktuasi drastis',
                3 => 'Cukup stabil - kadang ada fluktuasi emosi',
                4 => 'Stabil - emosi cukup terkontrol',
                5 => 'Sangat stabil - tenang dan positif',
            ],
            'dimensi' => 'depersonalisasi',
            'bobot_sbp' => 1.2,
        ],
        'prestasi' => [
            'label' => 'Kepuasan Prestasi Akademik',
            'pertanyaan' => 'Seberapa puas Anda dengan prestasi dan pencapaian akademik Anda?',
            'opsi' => [
                1 => 'Sangat tidak puas - merasa gagal total',
                2 => 'Tidak puas - di bawah ekspektasi',
                3 => 'Cukup puas - sesuai standar minimum',
                4 => 'Puas - memenuhi ekspektasi',
                5 => 'Sangat puas - melebihi ekspektasi',
            ],
            'dimensi' => 'prestasi',
            'bobot_sbp' => 1.0,
        ],
        'waktu' => [
            'label' => 'Manajemen Waktu',
            'pertanyaan' => 'Seberapa baik kemampuan Anda dalam mengatur dan mengelola waktu?',
            'opsi' => [
                1 => 'Sangat buruk - selalu terlambat, tidak terorganisir',
                2 => 'Buruk - sering kesulitan mengatur waktu',
                3 => 'Cukup - sesekali kesulitan manajemen waktu',
                4 => 'Baik - bisa mengatur waktu dengan cukup baik',
                5 => 'Sangat baik - terorganisir dan efisien',
            ],
            'dimensi' => 'prestasi',
            'bobot_sbp' => 1.0,
        ],
        'masa_depan' => [
            'label' => 'Kecemasan tentang Masa Depan',
            'pertanyaan' => 'Seberapa sering Anda merasa cemas atau khawatir tentang masa depan karir/kehidupan?',
            'opsi' => [
                1 => 'Sangat sering - hampir selalu cemas',
                2 => 'Sering - sering merasa khawatir',
                3 => 'Kadang-kadang - sesekali cemas',
                4 => 'Jarang - lebih banyak optimis',
                5 => 'Tidak pernah - sangat optimis tentang masa depan',
            ],
            'dimensi' => 'depersonalisasi',
            'bobot_sbp' => 0.9,
        ],
    ];

    /**
     * Proses utama inferensi SBP
     * Menggabungkan Forward Chaining dengan Certainty Factor (CF)
     */
    public function diagnose(array $jawaban): array
    {
        // 1. Normalisasi & validasi input
        $jawaban = $this->normalizeInput($jawaban);

        // 2. Hitung skor per dimensi (Maslach Burnout Inventory framework)
        $skorDimensi = $this->hitungSkorDimensi($jawaban);

        // 3. Hitung total skor SBP (0-100)
        $totalSkor = $this->hitungTotalSkor($jawaban, $skorDimensi);

        // 4. Inference Engine: Mencari semua rule yang cocok
        $ruleAktif = DiagnosisRule::aktif()->orderBy('bobot', 'desc')->get();
        $matchedRules = [];
        $penjelasan = [];
        
        $cfResults = [
            'Tinggi' => 0,
            'Sedang' => 0,
            'Rendah' => 0,
        ];

        foreach ($ruleAktif as $rule) {
            if ($this->evaluasiAturan($rule->kondisi_json, $jawaban)) {
                $matchedRules[] = $rule;
                
                // Hitung CF untuk rule ini: CF = CF[expert] * CF[user]
                $cfExpert = $rule->certainty_factor ?? 0.8;
                $cfUser = 1.0; // In standard SBP with flat forms, user confidence is assumed 100% per answer
                $cfRule = $cfExpert * $cfUser;

                // Gabungkan dengan CF sebelumnya untuk kategori risiko yang sama (CF_combine)
                $oldCf = $cfResults[$rule->hasil_risiko];
                $cfResults[$rule->hasil_risiko] = $oldCf + $cfRule * (1 - $oldCf);

                $penjelasan[] = [
                    'code' => $rule->rule_code,
                    'kondisi' => $rule->kondisi,
                    'hasil' => $rule->hasil_risiko,
                    'cf' => round($cfRule, 3),
                ];
            }
        }

        // 5. Tentukan hasil akhir berdasarkan CF tertinggi
        arsort($cfResults);
        $kategoriRisiko = key($cfResults);
        $cfFinalValue = current($cfResults);
        $ruleTerpilih = $matchedRules[0] ?? null;

        // Fallback jika tidak ada rule yang cocok
        if ($cfFinalValue == 0) {
            [$kategoriRisiko, $fallbackRekomendasi] = $this->fallbackKlasifikasi($totalSkor);
            $rekomendasi = $fallbackRekomendasi;
            $cfFinalValue = $totalSkor / 100;
        } else {
            $rekomendasi = $ruleTerpilih->rekomendasi;
        }

        return [
            'jawaban' => $jawaban,
            'skor_kelelahan' => $skorDimensi['kelelahan'],
            'skor_depersonalisasi' => $skorDimensi['depersonalisasi'],
            'skor_prestasi' => $skorDimensi['prestasi'],
            'total_skor' => $totalSkor,
            'kategori_risiko' => $kategoriRisiko,
            'cf_hasil' => round($cfFinalValue, 3), // Simpan desimal 0-1
            'rule_terpilih' => $ruleTerpilih?->rule_code,
            'rekomendasi' => $rekomendasi,
            'penjelasan' => $penjelasan,
            'detail_skor' => $this->generateDetailSkor($jawaban),
        ];
    }

    /**
     * Normalisasi input: pastikan semua 10 variabel ada dan valid (1-5)
     */
    private function normalizeInput(array $jawaban): array
    {
        $variabelKeys = array_keys(self::$variabel);
        $normalized = [];
        foreach ($variabelKeys as $key) {
            $val = isset($jawaban[$key]) ? (int) $jawaban[$key] : 3;
            $normalized[$key] = max(1, min(5, $val));
        }
        return $normalized;
    }

    /**
     * Hitung skor per dimensi burnout (Maslach Burnout Inventory)
     * Dimensi: Kelelahan Emosional, Depersonalisasi, Penurunan Prestasi
     */
    private function hitungSkorDimensi(array $jawaban): array
    {
        $dimensiMap = [];
        foreach (self::$variabel as $key => $config) {
            $dimensiMap[$config['dimensi']][] = [
                'nilai' => $jawaban[$key],
                'bobot' => $config['bobot_sbp'],
            ];
        }

        $hasil = [];
        foreach ($dimensiMap as $dimensi => $items) {
            $totalBobot = array_sum(array_column($items, 'bobot'));
            $skorRata = array_sum(array_map(fn($i) => $i['nilai'] * $i['bobot'], $items)) / $totalBobot;
            // Untuk kelelahan dan depersonalisasi: nilai rendah = risiko tinggi
            // Untuk prestasi: nilai rendah = risiko tinggi
            // Konversi ke 0-100 (makin tinggi = makin baik)
            $hasil[$dimensi] = round(($skorRata / 5) * 100);
        }

        return $hasil;
    }

    /**
     * Hitung total skor SBP (0-100)
     * Formula: rata-rata tertimbang dari semua variabel
     */
    private function hitungTotalSkor(array $jawaban, array $skorDimensi): int
    {
        $totalBobot = 0;
        $totalNilai = 0;

        foreach (self::$variabel as $key => $config) {
            $bobot = $config['bobot_sbp'];
            $totalBobot += $bobot;
            $totalNilai += $jawaban[$key] * $bobot;
        }

        $skorRata = $totalNilai / $totalBobot; // 1-5
        return (int) round(($skorRata / 5) * 100); // 0-100
    }

    /**
     * Evaluasi satu aturan IF-THEN terhadap data fakta jawaban
     */
    private function evaluasiAturan(array $kondisiJson, array $jawaban): bool
    {
        foreach ($kondisiJson as $kondisi) {
            if (!$this->evaluasiSatuKondisi($kondisi, $jawaban)) {
                return false; // AND logic - semua harus terpenuhi
            }
        }
        return true;
    }

    /**
     * Evaluasi satu kondisi individu
     */
    private function evaluasiSatuKondisi(array $kondisi, array $jawaban): bool
    {
        // Kondisi variabel tunggal
        if (isset($kondisi['variabel'])) {
            $nilai = $jawaban[$kondisi['variabel']] ?? 3;
            return match($kondisi['operator']) {
                '>=' => $nilai >= $kondisi['nilai'],
                '<=' => $nilai <= $kondisi['nilai'],
                '==' => $nilai == $kondisi['nilai'],
                '>'  => $nilai > $kondisi['nilai'],
                '<'  => $nilai < $kondisi['nilai'],
                default => false,
            };
        }

        // Kondisi khusus: hitung jumlah variabel di bawah threshold
        if (isset($kondisi['tipe'])) {
            return match($kondisi['tipe']) {
                'count_critical' => $this->evaluasiCountCritical($kondisi, $jawaban),
                'all_good' => $this->evaluasiAllGood($kondisi, $jawaban),
                default => false,
            };
        }

        return false;
    }

    /**
     * Hitung berapa variabel yang <= level tertentu
     */
    private function evaluasiCountCritical(array $kondisi, array $jawaban): bool
    {
        $count = 0;
        foreach ($jawaban as $nilai) {
            if ($nilai <= $kondisi['level']) {
                $count++;
            }
        }
        $min = $kondisi['threshold'];
        $max = $kondisi['max'] ?? 99;
        return $count >= $min && $count <= $max;
    }

    /**
     * Semua variabel >= level baik
     */
    private function evaluasiAllGood(array $kondisi, array $jawaban): bool
    {
        foreach ($jawaban as $nilai) {
            if ($nilai < $kondisi['level']) return false;
        }
        return true;
    }

    /**
     * Klasifikasi fallback berdasarkan total skor jika tidak ada rule yang cocok
     */
    private function fallbackKlasifikasi(int $totalSkor): array
    {
        if ($totalSkor >= 70) {
            return ['Rendah', 'Kondisi Anda secara keseluruhan cukup baik. Pertahankan kebiasaan positif dan lakukan self-check berkala.'];
        } elseif ($totalSkor >= 40) {
            return ['Sedang', 'Ada beberapa area yang perlu perhatian. Perhatikan keseimbangan antara akademik dan kehidupan pribadi Anda.'];
        } else {
            return ['Tinggi', 'Skor Anda menunjukkan risiko burnout yang signifikan. Pertimbangkan untuk berkonsultasi dengan konselor kampus.'];
        }
    }

    /**
     * Generate detail skor per variabel untuk visualisasi
     */
    private function generateDetailSkor(array $jawaban): array
    {
        $detail = [];
        foreach (self::$variabel as $key => $config) {
            $nilai = $jawaban[$key];
            $detail[$key] = [
                'label' => $config['label'],
                'nilai' => $nilai,
                'persentase' => ($nilai / 5) * 100,
                'status' => match(true) {
                    $nilai >= 4 => 'baik',
                    $nilai == 3 => 'cukup',
                    default => 'perlu_perhatian',
                },
                'dimensi' => $config['dimensi'],
            ];
        }
        return $detail;
    }

    /**
     * Simpan hasil diagnosis ke database
     */
    public function simpanHasil(array $hasil): DiagnosisSession
    {
        return DiagnosisSession::create([
            'user_id' => Auth::id(),
            'jawaban' => $hasil['jawaban'],
            'total_skor' => $hasil['total_skor'],
            'skor_kelelahan' => $hasil['skor_kelelahan'],
            'skor_depersonalisasi' => $hasil['skor_depersonalisasi'],
            'skor_prestasi' => $hasil['skor_prestasi'],
            'kategori_risiko' => $hasil['kategori_risiko'],
            'rule_terpilih' => $hasil['rule_terpilih'],
            'rekomendasi' => $hasil['rekomendasi'],
            'cf_hasil' => $hasil['cf_hasil'] ?? 0,
            'penjelasan' => $hasil['penjelasan'] ?? [],
        ]);
    }

    /**
     * Statistik untuk admin dashboard
     */
    public static function getStatistik(): array
    {
        $total = DiagnosisSession::count();
        return [
            'total' => $total,
            'rendah' => DiagnosisSession::where('kategori_risiko', 'Rendah')->count(),
            'sedang' => DiagnosisSession::where('kategori_risiko', 'Sedang')->count(),
            'tinggi' => DiagnosisSession::where('kategori_risiko', 'Tinggi')->count(),
            'rata_skor' => $total > 0 ? round(DiagnosisSession::avg('total_skor'), 1) : 0,
            'bulan_ini' => DiagnosisSession::whereMonth('created_at', now()->month)->count(),
        ];
    }
}
