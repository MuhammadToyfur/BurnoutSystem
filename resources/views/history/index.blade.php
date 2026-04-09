@extends('layouts.app')

@section('title', 'Riwayat Diagnosis')
@section('page-title', 'Riwayat Diagnosis')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" style="color:#4f46e5;text-decoration:none">Dashboard</a></li>
    <li class="breadcrumb-item active">Riwayat</li>
@endsection

@section('topbar-actions')
    <a href="{{ route('diagnosis.form') }}" class="btn-primary-custom">
        <i class="bi bi-plus-circle-fill"></i> Diagnosis Baru
    </a>
@endsection

@section('content')

{{-- Stats --}}
<div class="row g-4 mb-4">
    @php
        $totalR = $riwayat->where('kategori_risiko','Rendah')->count();
        $totalS = $riwayat->where('kategori_risiko','Sedang')->count();
        $totalT = $riwayat->where('kategori_risiko','Tinggi')->count();
        $rataRata = $riwayat->count() > 0 ? round($riwayat->avg('total_skor'), 1) : 0;
    @endphp
    @foreach([
        ['Total Diagnosis', $riwayat->total(), '#4f46e5', '#ede9fe', '📋'],
        ['Risiko Rendah', $totalR, '#16a34a', '#dcfce7', '✅'],
        ['Risiko Sedang', $totalS, '#d97706', '#fef3c7', '⚡'],
        ['Risiko Tinggi', $totalT, '#dc2626', '#fee2e2', '⚠️'],
    ] as [$label, $val, $color, $bg, $icon])
    <div class="col-6 col-md-3">
        <div class="stat-card" style="background:#fff">
            <div class="stat-icon" style="background:{{ $bg }}">{{ $icon }}</div>
            <div class="stat-value" style="color:{{ $color }}">{{ $val }}</div>
            <div class="stat-label">{{ $label }}</div>
        </div>
    </div>
    @endforeach
</div>

{{-- Chart Perbandingan Waktu --}}
@if($chartData->count() > 1)
<div class="card mb-4">
    <div class="card-header"><i class="bi bi-graph-up me-2" style="color:#4f46e5"></i>Tren Skor Burnout</div>
    <div class="card-body p-4" style="height:220px">
        <canvas id="trendChart"></canvas>
    </div>
</div>
@endif

{{-- Table --}}
<div class="card">
    <div class="card-header"><i class="bi bi-table me-2" style="color:#4f46e5"></i>Semua Riwayat Diagnosis</div>
    <div class="card-body p-0">
        @forelse($riwayat as $item)
        <div class="d-flex align-items-center gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }} history-row">
            <div style="width:44px;height:44px;border-radius:12px;background:{{ $item->kategori_risiko==='Rendah'?'#dcfce7':($item->kategori_risiko==='Sedang'?'#fef3c7':'#fee2e2') }};display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0">
                {{ $item->kategori_risiko==='Rendah'?'✅':($item->kategori_risiko==='Sedang'?'⚡':'⚠️') }}
            </div>
            <div class="flex-1" style="min-width:0">
                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                    <span style="font-weight:700;font-size:0.9rem;color:#1e293b">Skor: {{ $item->total_skor }}/100</span>
                    <span class="badge-risiko badge-{{ strtolower($item->kategori_risiko) }}">{{ $item->kategori_risiko }}</span>
                    @if($item->rule_terpilih)
                    <span style="font-size:0.7rem;background:#f1f5f9;color:#475569;padding:2px 7px;border-radius:6px">{{ $item->rule_terpilih }}</span>
                    @endif
                </div>
                <div style="font-size:0.78rem;color:#94a3b8">{{ $item->created_at->format('l, d F Y — H:i') }} WIB</div>
            </div>
            <div class="d-none d-md-flex gap-2 flex-shrink-0">
                <div style="text-align:center">
                    <div style="font-size:0.72rem;color:#94a3b8">Kelelahan</div>
                    <div style="font-size:0.82rem;font-weight:700;color:#ef4444">{{ $item->skor_kelelahan }}%</div>
                </div>
                <div style="text-align:center;margin:0 8px">
                    <div style="font-size:0.72rem;color:#94a3b8">Depersonal.</div>
                    <div style="font-size:0.82rem;font-weight:700;color:#f59e0b">{{ $item->skor_depersonalisasi }}%</div>
                </div>
                <div style="text-align:center">
                    <div style="font-size:0.72rem;color:#94a3b8">Prestasi</div>
                    <div style="font-size:0.82rem;font-weight:700;color:#10b981">{{ $item->skor_prestasi }}%</div>
                </div>
            </div>
            <div class="d-flex gap-1 flex-shrink-0">
                <a href="{{ route('diagnosis.hasil', $item->id) }}" class="btn btn-sm" style="background:#ede9fe;color:#4f46e5;border-radius:7px;padding:5px 9px;font-size:0.78rem;text-decoration:none;font-weight:600" title="Detail">
                    <i class="bi bi-eye"></i>
                </a>
                <a href="{{ route('diagnosis.cetak', $item->id) }}" class="btn btn-sm" style="background:#dcfce7;color:#16a34a;border-radius:7px;padding:5px 9px;font-size:0.78rem;text-decoration:none;font-weight:600" title="PDF">
                    <i class="bi bi-file-pdf"></i>
                </a>
            </div>
        </div>
        @empty
        <div class="p-5 text-center">
            <div style="font-size:3rem;margin-bottom:12px">📋</div>
            <h6 style="font-weight:700;color:#1e293b">Belum Ada Riwayat</h6>
            <p style="font-size:0.875rem;color:#64748b;margin-bottom:16px">Anda belum pernah melakukan diagnosis.</p>
            <a href="{{ route('diagnosis.form') }}" class="btn-primary-custom">Mulai Sekarang</a>
        </div>
        @endforelse
    </div>
    @if($riwayat->hasPages())
    <div class="card-footer d-flex justify-content-center py-3">
        {{ $riwayat->links() }}
    </div>
    @endif
</div>
@endsection

@section('scripts')
@if($chartData->count() > 1)
<script>
const ctx = document.getElementById('trendChart').getContext('2d');

// Plugin untuk membuat zona warna background (Merah, Kuning, Hijau)
const bgPlugin = {
    id: 'customCanvasBackgroundColor',
    beforeDraw: (chart, args, options) => {
        const {ctx, chartArea: {top, bottom, left, right, width, height}, scales: {y}} = chart;
        
        const drawZone = (yStart, yEnd, color) => {
            ctx.fillStyle = color;
            ctx.fillRect(left, y.getPixelForValue(yEnd), width, y.getPixelForValue(yStart) - y.getPixelForValue(yEnd));
        };

        // Area Merah (Skor 0-40 - Risiko Tinggi) -> Catatan: MBI biasanya skor tinggi = risiko tinggi
        // Namun di sistem Anda, total_skor rendah = kondisi buruk.
        // Berdasarkan fallbackKlasifikasi: <40 Tinggi, 40-70 Sedang, >70 Rendah
        drawZone(0, 40, 'rgba(239, 68, 68, 0.05)');   // Merah (Bahaya)
        drawZone(40, 70, 'rgba(245, 158, 11, 0.05)'); // Kuning (Waspada)
        drawZone(70, 100, 'rgba(16, 185, 129, 0.05)'); // Hijau (Aman)
    }
};

new Chart(ctx, {
    type: 'line',
    plugins: [bgPlugin],
    data: {
        labels: @json($chartData->map(fn($d, $i) => ["Sesi " . ($i + 1), $d->created_at->format('d M')])),
        datasets: [{
            label: 'Tingkat Kepastian SBP (%)',
            data: @json($chartData->map(fn($d) => ($d->cf_hasil > 0 ? $d->cf_hasil : $d->total_skor / 100) * 100)),
            borderColor: '#4f46e5',
            backgroundColor: 'rgba(79, 70, 229, 0.2)',
            fill: true,
            tension: 0.4,
            pointBackgroundColor: @json($chartData->map(fn($d) => $d->kategori_risiko==='Rendah'?'#16a34a':($d->kategori_risiko==='Sedang'?'#d97706':'#dc2626'))),
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 6,
            pointHoverRadius: 9,
            pointHoverBorderWidth: 3,
            borderWidth: 3,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { 
                min: 0, max: 100, 
                grid: { color: '#f1f5f9' },
                title: { display: true, text: 'Kepastian Pakar (%)', font: { size: 10, weight: 'bold' } },
                ticks: { font: { size: 10 } } 
            },
            x: { 
                grid: { display: false },
                ticks: { 
                    font: { size: 9, weight: '600' },
                    padding: 10
                }
            }
        },
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1e293b',
                padding: 15,
                titleFont: { size: 13, weight: 'bold', family: 'Sora' },
                bodyFont: { size: 12 },
                cornerRadius: 10,
                displayColors: true,
                callbacks: {
                    title: function(context) {
                        return 'Diagnosis ' + context[0].label[0];
                    },
                    label: function(context) {
                        return ' Kepastian: ' + context.raw + '%';
                    },
                    afterLabel: (ctx) => {
                        const items = @json($chartData->values()->map(fn($d) => [
                            'tgl' => $d->created_at->format('l, d F Y (H:i)'),
                            'kat' => $d->kategori_risiko
                        ]));
                        const item = items[ctx.dataIndex];
                        return [
                            ' Waktu: ' + item.tgl,
                            ' Risiko: ' + item.kat
                        ];
                    }
                }
            }
        }
    }
});
</script>
@endif
@endsection
