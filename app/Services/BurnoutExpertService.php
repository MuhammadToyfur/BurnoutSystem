<?php

namespace App\Services;

use App\Models\DiagnosisRule;
use App\Models\DiagnosisSession;
use Illuminate\Support\Facades\Auth;

class BurnoutExpertService
{
    // Definisi variabel dataset baru
    public static array $variabel = [
        'age' => ['label' => 'Usia', 'tipe' => 'number', 'min' => 15, 'max' => 50],
        'gender' => ['label' => 'Jenis Kelamin', 'tipe' => 'select', 'opsi' => ['Male'=>'Laki-laki', 'Female'=>'Perempuan', 'Other'=>'Lainnya']],
        'course' => ['label' => 'Program Studi', 'tipe' => 'select', 'opsi' => ['BTech'=>'BTech', 'BCA'=>'BCA', 'BSc'=>'BSc', 'MBA'=>'MBA', 'MCA'=>'MCA', 'BBA'=>'BBA']],
        'year' => ['label' => 'Tahun Kuliah', 'tipe' => 'select', 'opsi' => ['1st'=>'Tahun 1', '2nd'=>'Tahun 2', '3rd'=>'Tahun 3', '4th'=>'Tahun 4']],
        'daily_study_hours' => ['label' => 'Jam Belajar Harian', 'tipe' => 'number', 'step' => '0.1'],
        'daily_sleep_hours' => ['label' => 'Jam Tidur Harian', 'tipe' => 'number', 'step' => '0.1'],
        'screen_time_hours' => ['label' => 'Screen Time Harian', 'tipe' => 'number', 'step' => '0.1'],
        'stress_level' => ['label' => 'Tingkat Stres', 'tipe' => 'select', 'opsi' => ['Low'=>'Rendah', 'Medium'=>'Sedang', 'High'=>'Tinggi']],
        'anxiety_score' => ['label' => 'Skor Kecemasan', 'tipe' => 'number', 'min' => 0, 'max' => 10],
        'depression_score' => ['label' => 'Skor Depresi', 'tipe' => 'number', 'min' => 0, 'max' => 10],
        'academic_pressure_score' => ['label' => 'Tekanan Akademik', 'tipe' => 'number', 'min' => 0, 'max' => 10],
        'financial_stress_score' => ['label' => 'Stres Keuangan', 'tipe' => 'number', 'min' => 0, 'max' => 10],
        'social_support_score' => ['label' => 'Dukungan Sosial', 'tipe' => 'number', 'min' => 0, 'max' => 10],
        'physical_activity_hours' => ['label' => 'Aktivitas Fisik', 'tipe' => 'number', 'step' => '0.1'],
        'sleep_quality' => ['label' => 'Kualitas Tidur', 'tipe' => 'select', 'opsi' => ['Poor'=>'Buruk', 'Average'=>'Rata-rata', 'Good'=>'Baik']],
        'attendance_percentage' => ['label' => 'Persentase Kehadiran', 'tipe' => 'number', 'step' => '0.1', 'min' => 0, 'max' => 100],
        'cgpa' => ['label' => 'IPK (CGPA)', 'tipe' => 'number', 'step' => '0.01', 'min' => 0, 'max' => 10],
        'internet_quality' => ['label' => 'Kualitas Internet', 'tipe' => 'select', 'opsi' => ['Poor'=>'Buruk', 'Average'=>'Rata-rata', 'Good'=>'Baik']],
    ];

    public function diagnose(array $jawaban): array
    {
        $jawaban = $this->normalizeInput($jawaban);
        $totalSkor = $this->hitungTotalSkor($jawaban);

        $ruleAktif = DiagnosisRule::aktif()->orderBy('bobot', 'desc')->get();
        $matchedRules = [];
        $penjelasan = [];
        
        $cfResults = [
            'High' => 0.0,
            'Medium' => 0.0,
            'Low' => 0.0,
        ];

        foreach ($ruleAktif as $rule) {
            if ($this->evaluasiAturan($rule->kondisi_json, $jawaban)) {
                $matchedRules[] = $rule;
                
                $cfExpert = $rule->certainty_factor ?? 0.8;
                $cfUser = 1.0; 
                $cfRule = $cfExpert * $cfUser;

                $hasil = $rule->hasil_risiko;
                if ($hasil == 'Tinggi') $hasil = 'High';
                if ($hasil == 'Sedang') $hasil = 'Medium';
                if ($hasil == 'Rendah') $hasil = 'Low';

                if (isset($cfResults[$hasil])) {
                    $oldCf = $cfResults[$hasil];
                    $cfResults[$hasil] = $oldCf + $cfRule * (1 - $oldCf);
                }

                $penjelasan[] = [
                    'code' => $rule->rule_code,
                    'kondisi' => $rule->kondisi,
                    'hasil' => $hasil,
                    'cf' => round($cfRule, 3),
                ];
            }
        }

        arsort($cfResults);
        $burnoutLevel = key($cfResults);
        $cfFinalValue = current($cfResults);
        $ruleTerpilih = $matchedRules[0] ?? null;

        if ($cfFinalValue == 0) {
            [$burnoutLevel, $rekomendasi] = $this->fallbackKlasifikasi($totalSkor);
            $cfFinalValue = $totalSkor / 100;
        } else {
            $rekomendasi = $ruleTerpilih->rekomendasi;
        }

        return [
            'jawaban' => $jawaban,
            'total_skor' => $totalSkor,
            'burnout_level' => $burnoutLevel,
            'cf_hasil' => round((float)$cfFinalValue, 3), 
            'rule_terpilih' => $ruleTerpilih?->rule_code,
            'rekomendasi' => $rekomendasi,
            'penjelasan' => $penjelasan,
            'detail_skor' => $this->generateDetailSkor($jawaban),
        ];
    }

    private function normalizeInput(array $jawaban): array
    {
        $normalized = [];
        foreach (self::$variabel as $key => $config) {
            $val = $jawaban[$key] ?? null;
            if ($config['tipe'] === 'number') {
                $val = (float) $val;
            }
            $normalized[$key] = $val;
        }
        return $normalized;
    }

    private function hitungTotalSkor(array $jawaban): int
    {
        // Simple mock score approach since we don't have weighted inputs like MBI.
        // Higher score = better mental state.
        $score = 50; 
        
        $score -= ($jawaban['depression_score'] ?? 0) * 2;
        $score -= ($jawaban['anxiety_score'] ?? 0) * 2;
        $score -= ($jawaban['academic_pressure_score'] ?? 0) * 1.5;
        $score += ($jawaban['social_support_score'] ?? 0) * 2;
        $score += ($jawaban['sleep_quality'] === 'Good' ? 10 : ($jawaban['sleep_quality'] === 'Poor' ? -10 : 0));
        
        return (int) max(0, min(100, $score));
    }

    private function evaluasiAturan(array $kondisiJson, array $jawaban): bool
    {
        foreach ($kondisiJson as $kondisi) {
            if (!$this->evaluasiSatuKondisi($kondisi, $jawaban)) {
                return false; 
            }
        }
        return true;
    }

    private function evaluasiSatuKondisi(array $kondisi, array $jawaban): bool
    {
        if (isset($kondisi['variabel'])) {
            $nilai = $jawaban[$kondisi['variabel']] ?? null;
            return match($kondisi['operator']) {
                '>=' => $nilai >= $kondisi['nilai'],
                '<=' => $nilai <= $kondisi['nilai'],
                '==' => $nilai == $kondisi['nilai'],
                '>'  => $nilai > $kondisi['nilai'],
                '<'  => $nilai < $kondisi['nilai'],
                default => false,
            };
        }
        return false;
    }

    private function fallbackKlasifikasi(int $totalSkor): array
    {
        if ($totalSkor >= 70) {
            return ['Low', 'Kondisi Anda secara keseluruhan cukup baik. Pertahankan kebiasaan positif dan lakukan self-check berkala.'];
        } elseif ($totalSkor >= 40) {
            return ['Medium', 'Ada beberapa area yang perlu perhatian. Perhatikan keseimbangan akademik dan kehidupan pribadi Anda.'];
        } else {
            return ['High', 'Skor Anda menunjukkan risiko burnout yang signifikan. Pertimbangkan untuk berkonsultasi dengan konselor kampus.'];
        }
    }

    private function generateDetailSkor(array $jawaban): array
    {
        $detail = [];
        foreach (self::$variabel as $key => $config) {
            $nilai = $jawaban[$key] ?? '-';
            $detail[$key] = [
                'label' => $config['label'],
                'nilai' => is_numeric($nilai) ? round($nilai, 2) : $nilai,
                'persentase' => 50, // Disabled representation for direct mappings
                'status' => 'cukup',
            ];
        }
        return $detail;
    }

    public function simpanHasil(array $hasil): DiagnosisSession
    {
        $data = $hasil['jawaban'] + [
            'user_id' => Auth::id(),
            'total_skor' => $hasil['total_skor'],
            'burnout_level' => $hasil['burnout_level'],
            'rule_terpilih' => $hasil['rule_terpilih'],
            'rekomendasi' => $hasil['rekomendasi'],
            'cf_hasil' => $hasil['cf_hasil'] ?? 0,
            'penjelasan' => $hasil['penjelasan'] ?? [],
        ];
        return DiagnosisSession::create($data);
    }

    public static function getStatistik(): array
    {
        $total = DiagnosisSession::count();
        return [
            'total' => $total,
            'rendah' => DiagnosisSession::whereIn('burnout_level', ['Low', 'Rendah'])->count(),
            'sedang' => DiagnosisSession::whereIn('burnout_level', ['Medium', 'Sedang'])->count(),
            'tinggi' => DiagnosisSession::whereIn('burnout_level', ['High', 'Tinggi'])->count(),
            'rata_skor' => $total > 0 ? round(DiagnosisSession::avg('total_skor'), 1) : 0,
            'bulan_ini' => DiagnosisSession::whereMonth('created_at', now()->month)->count(),
        ];
    }
}

