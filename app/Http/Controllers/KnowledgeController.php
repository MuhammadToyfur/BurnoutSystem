<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiagnosisRule;

class KnowledgeController extends Controller
{
    public function index()
    {
        // Ambil semua rule (urut berdasarkan bobot tertinggi)
        $rules = DiagnosisRule::orderByDesc('bobot')->get();

        // Statistik
        $stats = [
            'total' => $rules->count(),
            'tinggi' => $rules->where('hasil_risiko', 'Tinggi')->count(),
            'sedang' => $rules->where('hasil_risiko', 'Sedang')->count(),
            'rendah' => $rules->where('hasil_risiko', 'Rendah')->count(),
        ];

        // Variabel (ini biasanya statis dari sistem pakar kamu)
        $variabel = [
            'q1' => [
                'label' => 'Saya merasa lelah secara emosional',
                'dimensi' => 'kelelahan',
                'bobot_sbp' => 5,
            ],
            'q2' => [
                'label' => 'Saya merasa kehabisan energi saat belajar',
                'dimensi' => 'kelelahan',
                'bobot_sbp' => 5,
            ],
            'q3' => [
                'label' => 'Saya mulai bersikap sinis terhadap kuliah',
                'dimensi' => 'depersonalisasi',
                'bobot_sbp' => 4,
            ],
            'q4' => [
                'label' => 'Saya merasa tidak peduli dengan tugas',
                'dimensi' => 'depersonalisasi',
                'bobot_sbp' => 4,
            ],
            'q5' => [
                'label' => 'Saya merasa tidak produktif',
                'dimensi' => 'prestasi',
                'bobot_sbp' => 3,
            ],
            'q6' => [
                'label' => 'Saya merasa kemampuan saya menurun',
                'dimensi' => 'prestasi',
                'bobot_sbp' => 3,
            ],
        ];

        return view('knowledge.index', compact('rules', 'stats', 'variabel'));
    }
}