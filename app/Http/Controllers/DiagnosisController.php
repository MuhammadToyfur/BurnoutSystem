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
        foreach (BurnoutExpertService::$variabel as $key => $config) {
            if ($config['tipe'] === 'number') {
                $rule = ['required', 'numeric'];
                if (isset($config['min'])) $rule[] = 'min:' . $config['min'];
                if (isset($config['max'])) $rule[] = 'max:' . $config['max'];
                $rules[$key] = implode('|', $rule);
            } else {
                $rules[$key] = 'required|string';
            }
        }

        $request->validate($rules, [
            '*.required' => 'Semua kolom wajib diisi.',
            '*.numeric' => 'Kolom harus berupa angka.',
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
        $jawaban = $session->only(array_keys($variabel));
        $detailSkor = $this->buildDetailSkor($jawaban, $variabel);

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
        $jawaban = $session->only(array_keys($variabel));
        $detailSkor = $this->buildDetailSkor($jawaban, $variabel);

        $pdf = Pdf::loadView('diagnosis.pdf', compact('session', 'variabel', 'detailSkor'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('laporan-burnout-' . $session->user->nim . '-' . $session->created_at->format('Ymd') . '.pdf');
    }

    private function buildDetailSkor(array $jawaban, array $variabel): array
    {
        $detail = [];
        foreach ($variabel as $key => $config) {
            $nilai = $jawaban[$key] ?? '-';
            $opsiLabel = '-';
            
            if ($config['tipe'] === 'select' && isset($config['opsi'][$nilai])) {
                $opsiLabel = $config['opsi'][$nilai];
            } else {
                $opsiLabel = is_numeric($nilai) ? round((float)$nilai, 2) : $nilai;
            }

            $persentase = 50;
            if ($config['tipe'] === 'number' && is_numeric($nilai)) {
                $min = $config['min'] ?? 0;
                $max = $config['max'] ?? 100;
                if ($max > $min) {
                    $persentase = (($nilai - $min) / ($max - $min)) * 100;
                }
            }

            $detail[$key] = [
                'label' => $config['label'],
                'nilai' => $nilai,
                'opsi_label' => $opsiLabel,
                'persentase' => max(0, min(100, $persentase)),
                'status' => 'cukup',
                'dimensi' => $config['dimensi'] ?? '-',
            ];
        }
        return $detail;
    }
}
