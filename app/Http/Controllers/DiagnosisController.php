<?php

namespace App\Http\Controllers;

use App\Services\BurnoutExpertService;
use Illuminate\Http\Request;
use App\Models\DiagnosisSession;
use Barryvdh\DomPDF\Facade\Pdf;

class DiagnosisController extends Controller
{
    public function __construct(private BurnoutExpertService $expertService) {}

    /**
     * Form diagnosis - halaman input 10 variabel
     */
    public function form()
    {
        $variabel = BurnoutExpertService::$variabel;
        return view('diagnosis.form', compact('variabel'));
    }

    /**
     * Proses diagnosis menggunakan mesin inferensi SBP
     */
    public function proses(Request $request)
    {
        // Validasi input
        $rules = [];
        foreach (array_keys(BurnoutExpertService::$variabel) as $key) {
            $rules[$key] = 'required|integer|min:1|max:5';
        }

        $request->validate($rules, [
            '*.required' => 'Semua pertanyaan wajib dijawab.',
            '*.integer' => 'Jawaban harus berupa angka.',
            '*.min' => 'Nilai minimal adalah 1.',
            '*.max' => 'Nilai maksimal adalah 5.',
        ]);

        $jawaban = $request->only(array_keys(BurnoutExpertService::$variabel));

        // Jalankan mesin inferensi SBP
        $hasil = $this->expertService->diagnose($jawaban);

        // Simpan ke database
        $session = $this->expertService->simpanHasil($hasil);

        // Simpan hasil di session untuk halaman hasil
        session(['diagnosis_hasil' => $hasil, 'diagnosis_session_id' => $session->id]);

        return redirect()->route('diagnosis.hasil', $session->id);
    }

    /**
     * Halaman hasil diagnosis
     */
    public function hasil($id)
    {
        $session = DiagnosisSession::with('user')->findOrFail($id);

        // Pastikan user hanya bisa lihat milik sendiri (kecuali admin)
        if (!auth()->user()->isAdmin() && $session->user_id !== auth()->id()) {
            abort(403);
        }

        $variabel = BurnoutExpertService::$variabel;
        $detailSkor = $this->buildDetailSkor($session->jawaban, $variabel);

        return view('diagnosis.hasil', compact('session', 'variabel', 'detailSkor'));
    }

    /**
     * Halaman rekomendasi
     */
    public function rekomendasi($id)
    {
        $session = DiagnosisSession::findOrFail($id);
        if (!auth()->user()->isAdmin() && $session->user_id !== auth()->id()) {
            abort(403);
        }
        return view('diagnosis.rekomendasi', compact('session'));
    }

    /**
     * Export PDF hasil diagnosis
     */
    public function exportPdf($id)
    {
        $session = DiagnosisSession::with('user')->findOrFail($id);
        if (!auth()->user()->isAdmin() && $session->user_id !== auth()->id()) {
            abort(403);
        }

        $variabel = BurnoutExpertService::$variabel;
        $detailSkor = $this->buildDetailSkor($session->jawaban, $variabel);

        $pdf = Pdf::loadView('diagnosis.pdf', compact('session', 'variabel', 'detailSkor'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('laporan-burnout-' . $session->user->nim . '-' . $session->created_at->format('Ymd') . '.pdf');
    }

    private function buildDetailSkor(array $jawaban, array $variabel): array
    {
        $detail = [];
        foreach ($variabel as $key => $config) {
            $nilai = $jawaban[$key] ?? 3;
            $detail[$key] = [
                'label' => $config['label'],
                'nilai' => $nilai,
                'opsi_label' => $config['opsi'][$nilai] ?? '-',
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
}
