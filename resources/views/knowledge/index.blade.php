@extends('layouts.app')

@section('title', 'Knowledge Base')
@section('page-title', 'Knowledge Base')

@section('breadcrumb')
    <li class="breadcrumb-item active">Knowledge Base</li>
@endsection

@section('content')

{{-- Header --}}
<div class="card mb-4" style="background:linear-gradient(135deg,#312e81,#1e40af)">
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4 style="font-family:'Sora',sans-serif;color:#fff;font-weight:700;margin-bottom:8px">
                    📚 Basis Pengetahuan Sistem Pakar
                </h4>
                <p style="color:rgba(255,255,255,0.7);font-size:0.875rem;margin:0">
                    Halaman ini menampilkan seluruh aturan <strong style="color:#a5b4fc">IF-THEN</strong> yang digunakan mesin inferensi
                    <strong style="color:#a5b4fc">Forward Chaining</strong> untuk mendiagnosis burnout mahasiswa.
                    Aturan dievaluasi berdasarkan bobot prioritas (tertinggi ke terendah).
                </p>
            </div>
            <div class="col-md-4 d-none d-md-flex justify-content-end gap-3">
                @foreach([['Total Aturan', $stats['total'], '#fff'], ['Risiko Tinggi', $stats['tinggi'], '#fca5a5'], ['Risiko Sedang', $stats['sedang'], '#fde68a'], ['Risiko Rendah', $stats['rendah'], '#bbf7d0']] as [$lbl, $val, $col])
                <div style="text-align:center">
                    <div style="font-family:'Sora',sans-serif;font-size:1.5rem;font-weight:800;color:{{ $col }}">{{ $val }}</div>
                    <div style="font-size:0.7rem;color:rgba(255,255,255,0.5)">{{ $lbl }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Penjelasan Dimensi --}}
<div class="row g-3 mb-4">
    @foreach([
        ['🔴', 'Kelelahan Emosional', 'Merasa terkuras secara emosional akibat pekerjaan/studi berlebihan.', '#fef2f2', '#dc2626'],
        ['🟡', 'Depersonalisasi', 'Sikap negatif, sinisme, atau jarak emosional dari lingkungan akademik.', '#fffbeb', '#d97706'],
        ['🟢', 'Penurunan Prestasi', 'Berkurangnya perasaan kompeten dan produktif dalam studi.', '#f0fdf4', '#16a34a'],
    ] as [$icon, $dim, $desc, $bg, $color])
    <div class="col-md-4">
        <div class="card" style="border-left:3px solid {{ $color }}">
            <div class="card-body p-3">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span style="font-size:1rem">{{ $icon }}</span>
                    <span style="font-weight:700;font-size:0.85rem;color:{{ $color }}">{{ $dim }}</span>
                </div>
                <p style="font-size:0.8rem;color:#64748b;margin:0">{{ $desc }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Filter Tabs --}}
<div class="d-flex gap-2 mb-4 flex-wrap">
    <button class="filter-btn active" data-filter="all" onclick="filterRules('all', this)">Semua ({{ $stats['total'] }})</button>
    <button class="filter-btn" data-filter="Tinggi" onclick="filterRules('Tinggi', this)">⚠️ Risiko Tinggi ({{ $stats['tinggi'] }})</button>
    <button class="filter-btn" data-filter="Sedang" onclick="filterRules('Sedang', this)">⚡ Risiko Sedang ({{ $stats['sedang'] }})</button>
    <button class="filter-btn" data-filter="Rendah" onclick="filterRules('Rendah', this)">✅ Risiko Rendah ({{ $stats['rendah'] }})</button>
</div>

{{-- Rules Cards --}}
<div id="rulesContainer">
    @foreach($rules as $rule)
    <div class="card mb-3 rule-card" data-risiko="{{ $rule->hasil_risiko }}">
        <div class="card-body p-0">
            <div class="d-flex">
                {{-- Left Accent --}}
                <div style="width:4px;background:{{ $rule->hasil_risiko==='Tinggi'?'#ef4444':($rule->hasil_risiko==='Sedang'?'#f59e0b':'#10b981') }};border-radius:16px 0 0 16px;flex-shrink:0"></div>
                <div class="p-4 flex-1">
                    <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap mb-3">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <span style="background:#f1f5f9;color:#475569;padding:3px 10px;border-radius:6px;font-size:0.75rem;font-weight:700;font-family:monospace">{{ $rule->rule_code }}</span>
                            <span class="badge-risiko badge-{{ strtolower($rule->hasil_risiko) }}">
                                {{ $rule->hasil_risiko==='Tinggi'?'⚠️':($rule->hasil_risiko==='Sedang'?'⚡':'✅') }}
                                Risiko {{ $rule->hasil_risiko }}
                            </span>
                            @if(!$rule->aktif)
                            <span style="background:#f1f5f9;color:#94a3b8;padding:3px 8px;border-radius:6px;font-size:0.72rem">Nonaktif</span>
                            @endif
                        </div>
                        <div style="display:flex;align-items:center;gap:6px">
                            <span style="font-size:0.72rem;color:#94a3b8">Bobot Prioritas:</span>
                            @for($i = 1; $i <= 10; $i++)
                            <div style="width:8px;height:8px;border-radius:2px;background:{{ $i <= $rule->bobot ? ($rule->hasil_risiko==='Tinggi'?'#ef4444':($rule->hasil_risiko==='Sedang'?'#f59e0b':'#10b981')) : '#e2e8f0' }}"></div>
                            @endfor
                            <span style="font-size:0.75rem;font-weight:700;color:#475569">{{ $rule->bobot }}/10</span>
                        </div>
                    </div>

                    {{-- IF Condition --}}
                    <div class="mb-3">
                        <div style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:#4f46e5;margin-bottom:6px">
                            <i class="bi bi-funnel-fill me-1"></i>IF (Kondisi)
                        </div>
                        <div style="background:#f8fafc;border-radius:8px;padding:12px;font-size:0.82rem;color:#374151;line-height:1.6;border:1px solid #e2e8f0">
                            {{ $rule->kondisi }}
                        </div>
                    </div>

                    {{-- THEN Result --}}
                    <div class="mb-3">
                        <div style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:#10b981;margin-bottom:6px">
                            <i class="bi bi-arrow-return-right me-1"></i>THEN (Hasil)
                        </div>
                        <div style="background:{{ $rule->hasil_risiko==='Tinggi'?'#fef2f2':($rule->hasil_risiko==='Sedang'?'#fffbeb':'#f0fdf4') }};border-radius:8px;padding:10px 12px;font-size:0.82rem;font-weight:600;color:{{ $rule->hasil_risiko==='Tinggi'?'#dc2626':($rule->hasil_risiko==='Sedang'?'#d97706':'#16a34a') }}">
                            Kategori Risiko Burnout: <strong>{{ $rule->hasil_risiko }}</strong>
                        </div>
                    </div>

                    {{-- Rekomendasi --}}
                    <div>
                        <div style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:#f59e0b;margin-bottom:6px">
                            <i class="bi bi-lightbulb-fill me-1"></i>Rekomendasi
                        </div>
                        <div style="font-size:0.82rem;color:#64748b;line-height:1.6">
                            {{ $rule->rekomendasi }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Variabel Reference --}}
<div class="card mt-4">
    <div class="card-header">
        <i class="bi bi-table me-2" style="color:#4f46e5"></i>Referensi Variabel SBP
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead style="background:#f8fafc">
                    <tr>
                        <th>No</th>
                        <th>Variabel</th>
                        <th>Label</th>
                        <th>Dimensi</th>
                        <th>Bobot SBP</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach($variabel as $key => $config)
                    <tr>
                        <td style="color:#94a3b8">{{ $no++ }}</td>
                        <td><code style="background:#f1f5f9;padding:2px 6px;border-radius:4px;font-size:0.8rem">{{ $key }}</code></td>
                        <td style="font-weight:600">{{ $config['label'] }}</td>
                        <td>
                            <span style="font-size:0.75rem;font-weight:600;padding:3px 8px;border-radius:6px;background:
                                @if($config['dimensi']==='kelelahan') #fef2f2
                                @elseif($config['dimensi']==='depersonalisasi') #fffbeb
                                @else #f0fdf4 @endif;
                                color:@if($config['dimensi']==='kelelahan') #dc2626
                                @elseif($config['dimensi']==='depersonalisasi') #d97706
                                @else #16a34a @endif">
                                {{ ucfirst($config['dimensi']) }}
                            </span>
                        </td>
                        <td style="font-weight:700;color:#4f46e5">{{ $config['bobot_sbp'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.filter-btn {
    padding: 7px 16px; border-radius: 20px; border: 1.5px solid #e2e8f0;
    font-size: 0.82rem; font-weight: 600; background: #fff; cursor: pointer;
    transition: all 0.15s; color: #475569;
}
.filter-btn:hover, .filter-btn.active {
    background: #4f46e5; color: #fff; border-color: #4f46e5;
}
</style>
@endsection

@section('scripts')
<script>
function filterRules(risiko, btn) {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.rule-card').forEach(card => {
        if (risiko === 'all' || card.dataset.risiko === risiko) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>
@endsection
