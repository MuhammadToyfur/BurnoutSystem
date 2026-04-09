@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('topbar-actions')
    <a href="{{ route('diagnosis.form') }}" class="btn-primary-custom">
        <i class="bi bi-clipboard2-pulse-fill"></i> Mulai Diagnosis
    </a>
@endsection

@section('content')
<div class="row g-4 mb-4">
    {{-- Welcome Card --}}
    <div class="col-12">
        <div class="card" style="background:linear-gradient(135deg,#4f46e5,#3730a3);border-radius:16px;overflow:hidden;position:relative">
            <div style="position:absolute;right:-30px;top:-30px;width:200px;height:200px;background:rgba(255,255,255,0.05);border-radius:50%"></div>
            <div style="position:absolute;right:40px;bottom:-40px;width:140px;height:140px;background:rgba(255,255,255,0.04);border-radius:50%"></div>
            <div class="card-body p-4 position-relative">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div style="font-size:0.8rem;color:rgba(255,255,255,0.6);margin-bottom:6px">
                            {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                        </div>
                        <h3 style="font-family:'Sora',sans-serif;color:#fff;font-weight:700;margin-bottom:8px">
                            Selamat datang, {{ explode(' ', $user->name)[0] }}! 👋
                        </h3>
                        <p style="color:rgba(255,255,255,0.7);margin-bottom:0;font-size:0.9rem">
                            @if($latestDiagnosis)
                                Diagnosis terakhir: <strong style="color:#a5b4fc">{{ $latestDiagnosis->created_at->diffForHumans() }}</strong>
                                — Risiko <strong style="color:#a5b4fc">{{ $latestDiagnosis->kategori_risiko }}</strong>
                            @else
                                Anda belum pernah melakukan diagnosis. Mulai sekarang!
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        @if(!$latestDiagnosis)
                            <a href="{{ route('diagnosis.form') }}" style="background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);color:#fff;padding:10px 20px;border-radius:10px;text-decoration:none;font-size:0.85rem;font-weight:600">
                                <i class="bi bi-clipboard2-plus me-1"></i> Diagnosis Pertama
                            </a>
                        @else
                            <a href="{{ route('diagnosis.form') }}" style="background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);color:#fff;padding:10px 20px;border-radius:10px;text-decoration:none;font-size:0.85rem;font-weight:600">
                                <i class="bi bi-arrow-repeat me-1"></i> Diagnosis Ulang
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Stat Cards --}}
<div class="row g-4 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card" style="background:#fff">
            <div class="stat-icon" style="background:#ede9fe">📋</div>
            <div class="stat-value" style="color:#4f46e5">{{ $totalDiagnosis }}</div>
            <div class="stat-label">Total Diagnosis</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card" style="background:#fff">
            <div class="stat-icon" style="background:{{ $latestDiagnosis ? ($latestDiagnosis->kategori_risiko === 'Rendah' ? '#dcfce7' : ($latestDiagnosis->kategori_risiko === 'Sedang' ? '#fef3c7' : '#fee2e2')) : '#f1f5f9' }}">
                {{ $latestDiagnosis ? ($latestDiagnosis->kategori_risiko === 'Rendah' ? '✅' : ($latestDiagnosis->kategori_risiko === 'Sedang' ? '⚡' : '⚠️')) : '➖' }}
            </div>
            <div class="stat-value" style="color:{{ $latestDiagnosis ? ($latestDiagnosis->kategori_risiko === 'Rendah' ? '#16a34a' : ($latestDiagnosis->kategori_risiko === 'Sedang' ? '#d97706' : '#dc2626')) : '#94a3b8' }};font-size:1.2rem">
                {{ $latestDiagnosis->kategori_risiko ?? '-' }}
            </div>
            <div class="stat-label">Risiko Terakhir</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card" style="background:#fff">
            <div class="stat-icon" style="background:#e0f2fe">📈</div>
            <div class="stat-value" style="color:#0284c7">{{ $latestDiagnosis->total_skor ?? '-' }}</div>
            <div class="stat-label">Skor Terakhir /100</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card" style="background:#fff">
            <div class="stat-icon" style="background:#fef3c7">🗓️</div>
            <div class="stat-value" style="color:#d97706;font-size:1.1rem">
                {{ $latestDiagnosis ? $latestDiagnosis->created_at->format('d M') : '-' }}
            </div>
            <div class="stat-label">Diagnosis Terakhir</div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Last Diagnosis Detail --}}
    <div class="col-lg-7">
        @if($latestDiagnosis)
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-activity" style="color:#4f46e5"></i>
                    <span>Hasil Diagnosis Terakhir</span>
                </div>
                <a href="{{ route('diagnosis.hasil', $latestDiagnosis->id) }}" style="font-size:0.8rem;color:#4f46e5;text-decoration:none">Lihat Detail →</a>
            </div>
            <div class="card-body p-4">
                <div class="row align-items-center mb-4">
                    <div class="col-5 text-center">
                        {{-- Score Ring --}}
                        <div style="position:relative;width:110px;height:110px;margin:0 auto">
                            <svg width="110" height="110" viewBox="0 0 110 110">
                                <circle cx="55" cy="55" r="45" fill="none" stroke="#f1f5f9" stroke-width="10"/>
                                <circle cx="55" cy="55" r="45" fill="none"
                                    stroke="{{ $latestDiagnosis->progress_color }}"
                                    stroke-width="10"
                                    stroke-dasharray="{{ 2 * pi() * 45 }}"
                                    stroke-dashoffset="{{ 2 * pi() * 45 * (1 - $latestDiagnosis->total_skor / 100) }}"
                                    stroke-linecap="round"
                                    transform="rotate(-90 55 55)"/>
                            </svg>
                            <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center">
                                <div style="font-family:'Sora',sans-serif;font-size:1.5rem;font-weight:800;color:#1e293b">{{ $latestDiagnosis->total_skor }}</div>
                                <div style="font-size:0.65rem;color:#94a3b8">/100</div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="badge-risiko badge-{{ strtolower($latestDiagnosis->kategori_risiko) }}">
                                Risiko {{ $latestDiagnosis->kategori_risiko }}
                            </span>
                        </div>
                    </div>
                    <div class="col-7">
                        @foreach([
                            ['Kelelahan', $latestDiagnosis->skor_kelelahan, '#ef4444'],
                            ['Depersonalisasi', $latestDiagnosis->skor_depersonalisasi, '#f59e0b'],
                            ['Prestasi', $latestDiagnosis->skor_prestasi, '#10b981'],
                        ] as [$label, $skor, $color])
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span style="font-size:0.78rem;font-weight:600;color:#475569">{{ $label }}</span>
                                <span style="font-size:0.78rem;font-weight:700;color:{{ $color }}">{{ $skor }}%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" style="width:{{ $skor }}%;background:{{ $color }}"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div style="background:#f8fafc;border-radius:10px;padding:14px;border-left:3px solid {{ $latestDiagnosis->progress_color }}">
                    <div style="font-size:0.75rem;font-weight:700;color:#4f46e5;margin-bottom:4px">REKOMENDASI</div>
                    <p style="font-size:0.82rem;color:#475569;margin:0;line-height:1.6">{{ Str::limit($latestDiagnosis->rekomendasi, 200) }}</p>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('diagnosis.hasil', $latestDiagnosis->id) }}" class="btn btn-sm" style="background:#ede9fe;color:#4f46e5;border-radius:8px;font-weight:600;font-size:0.8rem">
                        <i class="bi bi-bar-chart-fill me-1"></i> Detail Skor
                    </a>
                    <a href="{{ route('diagnosis.cetak', $latestDiagnosis->id) }}" class="btn btn-sm" style="background:#f0fdf4;color:#16a34a;border-radius:8px;font-weight:600;font-size:0.8rem">
                        <i class="bi bi-file-pdf me-1"></i> Cetak PDF
                    </a>
                </div>
            </div>
        </div>
        @else
        <div class="card h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center p-5 text-center">
                <div style="font-size:3rem;margin-bottom:16px">🩺</div>
                <h5 style="font-weight:700;color:#1e293b;margin-bottom:8px">Belum Ada Diagnosis</h5>
                <p style="color:#64748b;font-size:0.875rem;margin-bottom:20px">Mulai diagnosis pertama Anda untuk mengetahui tingkat risiko burnout.</p>
                <a href="{{ route('diagnosis.form') }}" class="btn-primary-custom">
                    <i class="bi bi-clipboard2-pulse-fill"></i> Mulai Sekarang
                </a>
            </div>
        </div>
        @endif
    </div>

    {{-- Riwayat & Artikel --}}
    <div class="col-lg-5">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-clock-history" style="color:#4f46e5"></i>
                    <span>Riwayat Diagnosis</span>
                </div>
                <a href="{{ route('history.index') }}" style="font-size:0.8rem;color:#4f46e5;text-decoration:none">Semua →</a>
            </div>
            <div class="card-body p-0">
                @forelse($riwayat as $item)
                <div class="d-flex align-items-center gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div style="width:36px;height:36px;border-radius:10px;background:{{ $item->kategori_risiko === 'Rendah' ? '#dcfce7' : ($item->kategori_risiko === 'Sedang' ? '#fef3c7' : '#fee2e2') }};display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:1rem">
                        {{ $item->kategori_risiko === 'Rendah' ? '✅' : ($item->kategori_risiko === 'Sedang' ? '⚡' : '⚠️') }}
                    </div>
                    <div class="flex-1" style="min-width:0">
                        <div style="font-size:0.82rem;font-weight:600;color:#1e293b">Skor: {{ $item->total_skor }}/100</div>
                        <div style="font-size:0.72rem;color:#94a3b8">{{ $item->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <span class="badge-risiko badge-{{ strtolower($item->kategori_risiko) }}" style="font-size:0.68rem">
                        {{ $item->kategori_risiko }}
                    </span>
                </div>
                @empty
                <div class="p-4 text-center" style="color:#94a3b8;font-size:0.85rem">Belum ada riwayat</div>
                @endforelse
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-lightning-fill me-2" style="color:#f59e0b"></i>Aksi Cepat</div>
            <div class="card-body p-3">
                <div class="row g-2">
                    @foreach([
                        [route('diagnosis.form'), 'bi-clipboard2-pulse-fill', '#ede9fe', '#4f46e5', 'Diagnosis Baru'],
                        [route('knowledge.index'), 'bi-lightbulb-fill', '#fef3c7', '#d97706', 'Knowledge Base'],
                        [route('articles.index'), 'bi-newspaper', '#dcfce7', '#16a34a', 'Artikel Tips'],
                        [route('history.index'), 'bi-clock-history', '#e0f2fe', '#0284c7', 'Lihat Riwayat'],
                    ] as [$url, $icon, $bg, $color, $label])
                    <div class="col-6">
                        <a href="{{ $url }}" style="display:flex;flex-direction:column;align-items:center;gap:6px;padding:14px;background:{{ $bg }};border-radius:10px;text-decoration:none;transition:all 0.2s" class="quick-action-btn">
                            <i class="bi {{ $icon }}" style="font-size:1.3rem;color:{{ $color }}"></i>
                            <span style="font-size:0.75rem;font-weight:600;color:#374151">{{ $label }}</span>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Artikel Tips --}}
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-newspaper" style="color:#10b981"></i>
                    <span>Artikel & Tips Terbaru</span>
                </div>
                <a href="{{ route('articles.index') }}" style="font-size:0.8rem;color:#10b981;text-decoration:none">Semua →</a>
            </div>
            <div class="card-body p-0">
                @forelse($articles as $article)
                <a href="{{ route('articles.show', $article->slug) }}" class="d-flex align-items-center gap-3 p-3 text-decoration-none {{ !$loop->last ? 'border-bottom' : '' }}" style="color:inherit">
                    <div style="width:48px;height:48px;border-radius:10px;background:#f0fdf4;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#16a34a;font-size:1.2rem">
                        <i class="bi bi-journal-text"></i>
                    </div>
                    <div class="flex-1" style="min-width:0">
                        <div style="font-size:0.85rem;font-weight:600;color:#1e293b;margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $article->judul }}</div>
                        <div style="font-size:0.75rem;color:#64748b">{{ $article->created_at->diffForHumans() }}</div>
                    </div>
                </a>
                @empty
                <div class="p-4 text-center" style="color:#94a3b8;font-size:0.85rem">Belum ada artikel.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.quick-action-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
</style>
@endsection
