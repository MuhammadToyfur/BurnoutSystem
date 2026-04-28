@extends('layouts.app')

@section('title', 'Hasil Diagnosis')
@section('page-title', 'Hasil Diagnosis Burnout')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" style="color:#4f46e5;text-decoration:none">Dashboard</a></li>
    <li class="breadcrumb-item active">Hasil Diagnosis</li>
@endsection

@section('topbar-actions')
    <a href="{{ route('diagnosis.cetak', $session->id) }}" class="btn btn-sm" style="background:#dcfce7;color:#16a34a;border-radius:8px;font-weight:600;font-size:0.82rem;padding:8px 14px;text-decoration:none">
        <i class="bi bi-file-pdf me-1"></i> Cetak PDF
    </a>
    <a href="{{ route('diagnosis.form') }}" class="btn-primary-custom" style="font-size:0.85rem;padding:8px 16px">
        <i class="bi bi-arrow-repeat"></i> Diagnosis Ulang
    </a>
@endsection

@section('content')

{{-- Result Hero --}}
@php
    $risikoConfig = [
        'Low' => ['bg' => 'linear-gradient(135deg,#065f46,#047857)', 'badge_bg' => '#bbf7d0', 'badge_color' => '#065f46', 'icon' => '✅', 'emoji' => '🎉'],
        'Medium' => ['bg' => 'linear-gradient(135deg,#92400e,#b45309)', 'badge_bg' => '#fde68a', 'badge_color' => '#92400e', 'icon' => '⚡', 'emoji' => '💪'],
        'High' => ['bg' => 'linear-gradient(135deg,#7f1d1d,#991b1b)', 'badge_bg' => '#fecaca', 'badge_color' => '#7f1d1d', 'icon' => '⚠️', 'emoji' => '🆘'],
        'Rendah' => ['bg' => 'linear-gradient(135deg,#065f46,#047857)', 'badge_bg' => '#bbf7d0', 'badge_color' => '#065f46', 'icon' => '✅', 'emoji' => '🎉'],
        'Sedang' => ['bg' => 'linear-gradient(135deg,#92400e,#b45309)', 'badge_bg' => '#fde68a', 'badge_color' => '#92400e', 'icon' => '⚡', 'emoji' => '💪'],
        'Tinggi' => ['bg' => 'linear-gradient(135deg,#7f1d1d,#991b1b)', 'badge_bg' => '#fecaca', 'badge_color' => '#7f1d1d', 'icon' => '⚠️', 'emoji' => '🆘'],
    ];
    $cfg = $risikoConfig[$session->burnout_level ?? 'Medium'];
@endphp

<div class="card mb-4" style="background:{{ $cfg['bg'] }};overflow:hidden;position:relative">
    <div style="position:absolute;right:-40px;top:-40px;width:200px;height:200px;background:rgba(255,255,255,0.06);border-radius:50%"></div>
    <div class="card-body p-4 position-relative">
        <div class="row align-items-center">
            <div class="col-md-3 text-center mb-3 mb-md-0">
                {{-- Score Ring SVG --}}
                <div style="position:relative;width:130px;height:130px;margin:0 auto">
                    <svg width="130" height="130" viewBox="0 0 130 130">
                        <circle cx="65" cy="65" r="52" fill="none" stroke="rgba(255,255,255,0.15)" stroke-width="12"/>
                        <circle cx="65" cy="65" r="52" fill="none"
                            stroke="rgba(255,255,255,0.9)"
                            stroke-width="12"
                            stroke-dasharray="{{ 2 * pi() * 52 }}"
                            stroke-dashoffset="{{ 2 * pi() * 52 * (1 - $session->total_skor / 100) }}"
                            stroke-linecap="round"
                            transform="rotate(-90 65 65)"
                            id="scoreArc"/>
                    </svg>
                    <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center">
                        <div style="font-family:'Sora',sans-serif;font-size:2rem;font-weight:800;color:#fff" id="scoreDisplay">0</div>
                        <div style="font-size:0.7rem;color:rgba(255,255,255,0.6)">/100</div>
                    </div>
                </div>
                <div style="font-size:0.78rem;color:rgba(255,255,255,0.6);margin-top:8px">Total Skor SBP</div>
            </div>
            <div class="col-md-6 mb-3 mb-md-0">
                <div style="display:inline-flex;align-items:center;gap:6px;background:{{ $cfg['badge_bg'] }};color:{{ $cfg['badge_color'] }};padding:5px 14px;border-radius:20px;font-size:0.8rem;font-weight:700;margin-bottom:12px">
                    {{ $cfg['icon'] }} RISIKO {{ strtoupper($session->burnout_level ?? 'Medium') }} ({{ number_format($session->cf_hasil * 100, 1) }}% Pasti)
                </div>
                <h3 style="font-family:'Sora',sans-serif;color:#fff;font-weight:700;margin-bottom:6px">
                    {{ $cfg['emoji'] }} Hasil Diagnosis Burnout
                </h3>
                <p style="color:rgba(255,255,255,0.7);font-size:0.875rem;margin-bottom:0">
                    Didiagnosis pada {{ $session->created_at->format('d F Y, H:i') }} WIB
                    @if($session->rule_terpilih)
                        &mdash; Aturan terpenuhi: <strong style="color:rgba(255,255,255,0.9)">{{ $session->rule_terpilih }}</strong>
                    @endif
                </p>
            </div>
            <div class="col-md-3">
                <div style="background:rgba(255,255,255,0.1);border-radius:12px;padding:14px">
                    <div class="d-flex justify-content-between pt-2">
                        <span style="font-size:0.75rem;color:rgba(255,255,255,0.6)">Pengguna</span>
                        <span style="font-size:0.75rem;font-weight:700;color:#fff">{{ $session->user->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    {{-- Detail per variabel --}}
    <div class="col-lg-12">
        <div class="card h-100">
            <div class="card-header"><i class="bi bi-list-check me-2" style="color:#4f46e5"></i>Detail Skor per Variabel</div>
            <div class="card-body p-3">
                @foreach($detailSkor as $key => $detail)
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div style="width:32px;text-align:center;font-size:0.72rem;font-weight:700;color:#10b981;flex-shrink:0">
                        INFO
                    </div>
                    <div class="flex-1" style="min-width:0">
                        <div class="d-flex justify-content-between mb-1">
                            <span style="font-size:0.78rem;font-weight:600;color:#374151;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:180px">
                                {{ $detail['label'] }}
                            </span>
                            <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                <span style="font-size:0.75rem;font-weight:700;color:#1e293b">{{ is_numeric($detail['nilai']) ? round((float)$detail['nilai'], 2) : $detail['nilai'] }}</span>
                                @if($detail['status'] === 'baik')
                                    <span style="font-size:0.65rem;background:#dcfce7;color:#16a34a;padding:2px 6px;border-radius:10px;font-weight:600">Baik</span>
                                @elseif($detail['status'] === 'cukup')
                                    <span style="font-size:0.65rem;background:#fef3c7;color:#d97706;padding:2px 6px;border-radius:10px;font-weight:600">Cukup</span>
                                @else
                                    <span style="font-size:0.65rem;background:#fee2e2;color:#dc2626;padding:2px 6px;border-radius:10px;font-weight:600">Perlu Perhatian</span>
                                @endif
                            </div>
                        </div>
                        <div class="progress" style="height:5px">
                            <div class="progress-bar" style="width:{{ $detail['persentase'] }}%;background:
                                @if($detail['status']==='baik') #10b981
                                @elseif($detail['status']==='cukup') #f59e0b
                                @else #ef4444
                                @endif"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Penjelasan Logika Pakar --}}
<div class="card mb-4 border-0 shadow-sm overflow-hidden" style="border-radius:16px">
    <div class="card-header bg-white border-0 py-3 shadow-sm" style="z-index:1">
        <div class="d-flex align-items-center justify-content-between">
            <h6 class="fw-bold mb-0" style="color:#1e293b">
                <i class="bi bi-cpu-fill me-1" style="color:#4f46e5"></i> Logika Pakar (Explanation Facility)
            </h6>
            <span class="badge" style="background:#eef2ff;color:#4f46e5;font-size:0.75rem">Certainty Factor: {{ number_format($session->cf_hasil * 100, 1) }}%</span>
        </div>
    </div>
    <div class="card-body p-0">
        <div style="background:#f8fafc;padding:24px">
            <div class="mb-3 d-flex align-items-center gap-2">
                <div style="width:10px;height:10px;background:#4f46e5;border-radius:50%"></div>
                <div style="font-size:0.85rem;font-weight:700;color:#1e293b">Penelusuran Aturan (Inference Trace)</div>
            </div>
            
            <div class="vstack gap-3">
                @if($session->penjelasan && count($session->penjelasan) > 0)
                    @foreach($session->penjelasan as $trace)
                    <div class="p-3 bg-white border rounded-3" style="border-left:4px solid #4f46e5 !important">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge" style="background:#f1f5f9;color:#475569;font-weight:800">{{ $trace['code'] }}</span>
                            <span style="font-size:0.78rem;font-weight:700;color:#059669">CF: {{ number_format($trace['cf'] * 100, 1) }}%</span>
                        </div>
                        <div style="font-size:0.88rem;color:#1e293b;margin-bottom:4px">
                            <strong>Logika:</strong> <span style="font-style:italic;color:#64748b">IF {{ $trace['kondisi'] }}</span>
                        </div>
                        <div style="font-size:0.88rem;color:#1e293b">
                            <strong>Then:</strong> <span class="fw-bold" style="color:{{ (in_array($trace['hasil'], ['Tinggi', 'High'])) ? '#dc2626' : (in_array($trace['hasil'], ['Sedang', 'Medium']) ? '#d97706' : '#16a34a') }}">{{ $trace['hasil'] }}</span>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-slash-circle mb-2 d-block fs-3"></i>
                        <span style="font-size:0.85rem">Tidak ada aturan spesifik yang mencapai batasan kritis. Diagnosis didasarkan pada akumulasi nilai rata-rata (Fallback).</span>
                    </div>
                @endif
            </div>

            <div class="mt-4 pt-3" style="border-top:1px dashed #cbd5e1">
                <div class="d-flex align-items-center gap-2 text-muted" style="font-size:0.75rem">
                    <i class="bi bi-info-circle-fill" style="color:#3b82f6"></i>
                    <span>Analisis ini dihitung menggunakan metode <strong>Certainty Factor</strong> yang memproses probabilitas keyakinan pakar terhadap gejala yang Anda alami.</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Rekomendasi --}}
<div class="card mb-4">
    <div class="card-header">
        <i class="bi bi-lightbulb-fill me-2" style="color:#f59e0b"></i>Rekomendasi Pakar & Tindakan
    </div>
    <div class="card-body p-4">
        <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:12px;padding:22px;border-left:5px solid #f59e0b;box-shadow:0 4px 6px -1px rgba(0,0,0,0.05)">
            <h6 class="fw-bold mb-2" style="color:#92400e">Saran Utama:</h6>
            <p style="color:#374151;line-height:1.8;margin:0;font-size:0.95rem">
                {{ $session->rekomendasi }}
            </p>
        </div>
        @if(in_array($session->burnout_level, ['High', 'Tinggi']))
        <div class="row g-3 mt-2">
            <div class="col-md-4">
                <div style="background:#fef2f2;border-radius:10px;padding:14px;text-align:center">
                    <div style="font-size:1.5rem;margin-bottom:6px">🏥</div>
                    <div style="font-size:0.8rem;font-weight:600;color:#dc2626">Konseling Kampus</div>
                    <div style="font-size:0.73rem;color:#9ca3af;margin-top:3px">Hubungi unit konseling kampus Anda</div>
                </div>
            </div>
            <div class="col-md-4">
                <div style="background:#fff7ed;border-radius:10px;padding:14px;text-align:center">
                    <div style="font-size:1.5rem;margin-bottom:6px">😴</div>
                    <div style="font-size:0.8rem;font-weight:600;color:#ea580c">Prioritaskan Tidur</div>
                    <div style="font-size:0.73rem;color:#9ca3af;margin-top:3px">Target 7-8 jam tidur berkualitas</div>
                </div>
            </div>
            <div class="col-md-4">
                <div style="background:#f0fdf4;border-radius:10px;padding:14px;text-align:center">
                    <div style="font-size:1.5rem;margin-bottom:6px">🤝</div>
                    <div style="font-size:0.8rem;font-weight:600;color:#16a34a">Cari Dukungan</div>
                    <div style="font-size:0.73rem;color:#9ca3af;margin-top:3px">Ceritakan kondisi ke orang terpercaya</div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Action Buttons --}}
<div class="card">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center">
            <div style="font-size:0.85rem;color:#64748b">
                <i class="bi bi-info-circle me-1"></i>
                Lakukan diagnosis secara berkala untuk memantau perkembangan kondisi Anda.
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('articles.index') }}" class="btn btn-sm" style="background:#fef3c7;color:#d97706;border-radius:8px;font-weight:600;font-size:0.82rem;padding:9px 16px;text-decoration:none">
                    <i class="bi bi-newspaper me-1"></i> Baca Artikel Tips
                </a>
                <a href="{{ route('diagnosis.cetak', $session->id) }}" class="btn btn-sm" style="background:#dcfce7;color:#16a34a;border-radius:8px;font-weight:600;font-size:0.82rem;padding:9px 16px;text-decoration:none">
                    <i class="bi bi-file-pdf me-1"></i> Cetak Laporan
                </a>
                <a href="{{ route('history.index') }}" class="btn btn-sm" style="background:#e0f2fe;color:#0284c7;border-radius:8px;font-weight:600;font-size:0.82rem;padding:9px 16px;text-decoration:none">
                    <i class="bi bi-clock-history me-1"></i> Riwayat
                </a>
                <a href="{{ route('diagnosis.form') }}" class="btn-primary-custom" style="font-size:0.85rem;padding:9px 18px">
                    <i class="bi bi-arrow-repeat"></i> Ulangi
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Score counter animation
const targetScore = {{ $session->total_skor }};
let current = 0;
const duration = 1200;
const step = targetScore / (duration / 16);
const el = document.getElementById('scoreDisplay');
const interval = setInterval(() => {
    current = Math.min(current + step, targetScore);
    el.textContent = Math.round(current);
    if (current >= targetScore) clearInterval(interval);
}, 16);


</script>
@endsection
