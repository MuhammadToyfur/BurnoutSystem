@extends('layouts.app')

@section('title', 'Form Diagnosis Burnout')
@section('page-title', 'Form Diagnosis Burnout')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" style="color:#4f46e5;text-decoration:none">Dashboard</a></li>
    <li class="breadcrumb-item active">Form Diagnosis</li>
@endsection

@section('content')

{{-- Intro Card --}}
<div class="card mb-4" style="border-left:4px solid #4f46e5">
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h5 style="font-weight:700;color:#1e293b;margin-bottom:6px">📋 Instruksi Pengisian</h5>
                <p style="color:#64748b;font-size:0.875rem;margin:0;line-height:1.6">
                    Jawab <strong>10 pertanyaan</strong> berikut secara jujur berdasarkan kondisi Anda
                    dalam <strong>2 minggu terakhir</strong>. Pilih jawaban yang paling mencerminkan keadaan Anda.
                    Tidak ada jawaban benar atau salah.
                </p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div style="background:#f1f5f9;border-radius:10px;padding:12px;display:inline-block;text-align:center">
                    <div style="font-size:0.72rem;color:#64748b">Estimasi Waktu</div>
                    <div style="font-family:'Sora',sans-serif;font-size:1.4rem;font-weight:700;color:#4f46e5">3 Menit</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Progress --}}
<div class="card mb-4">
    <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span style="font-size:0.8rem;font-weight:600;color:#475569">Progres Pengisian</span>
            <span style="font-size:0.8rem;font-weight:700;color:#4f46e5" id="progressText">0 / 10</span>
        </div>
        <div class="progress" style="height:6px">
            <div class="progress-bar" id="progressBar" style="width:0%;background:linear-gradient(90deg,#4f46e5,#06b6d4);transition:width 0.3s"></div>
        </div>
    </div>
</div>

{{-- Form --}}
<form action="{{ route('diagnosis.proses') }}" method="POST" id="diagnosisForm">
    @csrf

    @if($errors->any())
    <div class="alert alert-danger mb-4">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        Pastikan semua pertanyaan sudah dijawab.
    </div>
    @endif

    @php $no = 1; @endphp
    @foreach($variabel as $key => $config)
    <div class="card mb-3 question-card" id="qcard-{{ $key }}" data-key="{{ $key }}">
        <div class="card-body p-4">
            <div class="d-flex gap-3">
                {{-- Number badge --}}
                <div style="width:36px;height:36px;background:#f1f5f9;border-radius:10px;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.9rem;color:#475569;flex-shrink:0" class="q-number">
                    {{ $no }}
                </div>
                <div class="flex-1">
                    <div class="d-flex align-items-start justify-content-between gap-2 mb-1">
                        <div>
                            <span style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:
                                @if($config['dimensi']==='kelelahan') #ef4444
                                @elseif($config['dimensi']==='depersonalisasi') #f59e0b
                                @else #10b981
                                @endif">
                                {{ ucfirst($config['dimensi']) }}
                            </span>
                            <h6 style="font-weight:700;color:#1e293b;margin:4px 0 0;font-size:0.95rem">
                                {{ $config['label'] }}
                            </h6>
                        </div>
                    </div>
                    <p style="font-size:0.85rem;color:#64748b;margin-bottom:16px">{{ $config['pertanyaan'] }}</p>

                    {{-- Radio options --}}
                    <div class="options-grid">
                        @foreach($config['opsi'] as $nilai => $label)
                        <label class="option-label" for="{{ $key }}_{{ $nilai }}">
                            <input type="radio" name="{{ $key }}" id="{{ $key }}_{{ $nilai }}"
                                value="{{ $nilai }}"
                                {{ old($key) == $nilai ? 'checked' : '' }}
                                class="option-radio"
                                data-field="{{ $key }}">
                            <div class="option-content">
                                <div class="option-number">{{ $nilai }}</div>
                                <div class="option-text">{{ $label }}</div>
                            </div>
                        </label>
                        @endforeach
                    </div>

                    @error($key)
                    <div style="color:#ef4444;font-size:0.78rem;margin-top:6px">
                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    @php $no++; @endphp
    @endforeach

    {{-- Submit --}}
    <div class="card">
        <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <div style="font-size:0.85rem;font-weight:600;color:#1e293b">Sudah mengisi semua pertanyaan?</div>
                <div style="font-size:0.78rem;color:#64748b">Klik tombol untuk memproses diagnosis menggunakan mesin inferensi SBP.</div>
            </div>
            <button type="submit" class="btn-primary-custom" id="submitBtn" style="opacity:0.5;cursor:not-allowed" disabled>
                <i class="bi bi-cpu-fill"></i> Proses Diagnosis
            </button>
        </div>
    </div>
</form>
@endsection

@section('styles')
<style>
.question-card { transition: all 0.2s; }
.question-card.answered { border-color: #c7d2fe !important; }
.question-card.answered .q-number { background: #4f46e5; color: #fff; }

.options-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 8px;
}

.option-label { cursor: pointer; display: block; }
.option-radio { display: none; }

.option-content {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 10px 12px;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    transition: all 0.15s;
    background: #fafafa;
}

.option-content:hover {
    border-color: #a5b4fc;
    background: #f5f3ff;
}

.option-radio:checked + .option-content {
    border-color: #4f46e5;
    background: #ede9fe;
}

.option-number {
    width: 24px; height: 24px;
    background: #e2e8f0;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 0.78rem; color: #475569;
    flex-shrink: 0;
}

.option-radio:checked + .option-content .option-number {
    background: #4f46e5;
    color: #fff;
}

.option-text {
    font-size: 0.8rem;
    color: #374151;
    line-height: 1.4;
}

@media (max-width: 576px) {
    .options-grid { grid-template-columns: 1fr; }
}
</style>
@endsection

@section('scripts')
<script>
const totalFields = {{ count($variabel) }};
const answered = new Set();

document.querySelectorAll('.option-radio').forEach(radio => {
    radio.addEventListener('change', function () {
        const field = this.dataset.field;
        const card = document.getElementById('qcard-' + field);
        
        answered.add(field);
        card.classList.add('answered');

        // Update progress
        const pct = (answered.size / totalFields) * 100;
        document.getElementById('progressBar').style.width = pct + '%';
        document.getElementById('progressText').textContent = answered.size + ' / ' + totalFields;

        // Enable submit when all answered
        const btn = document.getElementById('submitBtn');
        if (answered.size >= totalFields) {
            btn.disabled = false;
            btn.style.opacity = '1';
            btn.style.cursor = 'pointer';
        }
    });
});

// Pre-fill from old values
document.querySelectorAll('.option-radio:checked').forEach(radio => {
    radio.dispatchEvent(new Event('change'));
});
</script>
@endsection
