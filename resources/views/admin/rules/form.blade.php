@extends('layouts.app')
@section('title', isset($rule->id) ? 'Edit Aturan' : 'Tambah Aturan')
@section('page-title', isset($rule->id) ? 'Edit Aturan IF-THEN' : 'Tambah Aturan IF-THEN')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" style="color:#4f46e5;text-decoration:none">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.rules.index') }}" style="color:#4f46e5;text-decoration:none">Aturan</a></li>
    <li class="breadcrumb-item active">{{ isset($rule->id) ? 'Edit' : 'Tambah' }}</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-diagram-3 me-2" style="color:#4f46e5"></i>
                {{ isset($rule->id) ? 'Edit Aturan: ' . $rule->rule_code : 'Tambah Aturan Baru' }}
            </div>
            <div class="card-body p-4">
                @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif

                <form action="{{ isset($rule->id) ? route('admin.rules.update', $rule) : route('admin.rules.store') }}" method="POST">
                    @csrf
                    @if(isset($rule->id)) @method('PUT') @endif

                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Kode Aturan <span style="color:#ef4444">*</span></label>
                            <input type="text" name="rule_code" class="form-control" style="border-radius:10px;text-transform:uppercase"
                                value="{{ old('rule_code', $rule->rule_code ?? '') }}"
                                placeholder="R14" {{ isset($rule->id) ? 'readonly' : 'required' }}>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Hasil Risiko <span style="color:#ef4444">*</span></label>
                            <select name="hasil_risiko" class="form-select" style="border-radius:10px" required>
                                @foreach(['Rendah', 'Sedang', 'Tinggi'] as $r)
                                <option value="{{ $r }}" {{ old('hasil_risiko', $rule->hasil_risiko ?? '') === $r ? 'selected' : '' }}>{{ $r }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Bobot Prioritas <span style="color:#ef4444">*</span></label>
                            <input type="number" name="bobot" class="form-control" style="border-radius:10px"
                                value="{{ old('bobot', $rule->bobot ?? 5) }}" min="1" max="10" required>
                            <div style="font-size:0.72rem;color:#94a3b8;margin-top:3px">1 (rendah) - 10 (tinggi)</div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input type="checkbox" name="aktif" class="form-check-input" id="aktif"
                                    {{ old('aktif', $rule->aktif ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="aktif" style="font-size:0.85rem">Aktif</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Kondisi IF <span style="color:#ef4444">*</span></label>
                            <textarea name="kondisi" class="form-control" style="border-radius:10px" rows="3" required
                                placeholder="Contoh: Beban tugas sangat tinggi DAN kualitas tidur sangat buruk DAN motivasi sangat rendah">{{ old('kondisi', $rule->kondisi ?? '') }}</textarea>
                            <div style="font-size:0.75rem;color:#64748b;margin-top:4px">Deskripsi kondisi dalam bahasa natural</div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Kondisi JSON (Opsional)</label>
                            <textarea name="kondisi_json" class="form-control" style="border-radius:10px;font-family:monospace;font-size:0.82rem" rows="5"
                                placeholder='[{"variabel": "beban_tugas", "operator": ">=", "nilai": 4}]'>{{ old('kondisi_json', isset($rule->kondisi_json) ? json_encode($rule->kondisi_json, JSON_PRETTY_PRINT) : '') }}</textarea>
                            <div style="font-size:0.75rem;color:#64748b;margin-top:4px">
                                Format JSON untuk mesin inferensi. Variabel: beban_tugas, tidur, motivasi, sosial, fisik, keuangan, emosi, prestasi, waktu, masa_depan
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Rekomendasi <span style="color:#ef4444">*</span></label>
                            <textarea name="rekomendasi" class="form-control" style="border-radius:10px" rows="4" required
                                placeholder="Saran dan rekomendasi yang akan ditampilkan kepada mahasiswa...">{{ old('rekomendasi', $rule->rekomendasi ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="btn-primary-custom">
                            <i class="bi bi-check-circle-fill"></i> {{ isset($rule->id) ? 'Update Aturan' : 'Simpan Aturan' }}
                        </button>
                        <a href="{{ route('admin.rules.index') }}" class="btn btn-sm" style="background:#f1f5f9;color:#475569;border-radius:10px;padding:10px 20px;font-weight:600;text-decoration:none">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Referensi --}}
        <div class="card mt-4">
            <div class="card-header"><i class="bi bi-info-circle me-2" style="color:#0284c7"></i>Referensi Format JSON</div>
            <div class="card-body">
                <p style="font-size:0.82rem;color:#64748b;margin-bottom:12px">Contoh format kondisi JSON yang valid:</p>
                <pre style="background:#f8fafc;border-radius:8px;padding:14px;font-size:0.78rem;overflow:auto">
// Kondisi variabel tunggal:
[
  {"variabel": "beban_tugas", "operator": ">=", "nilai": 4},
  {"variabel": "tidur", "operator": "&lt;=", "nilai": 2}
]

// Hitung variabel kritis (min 5, maks 99):
[{"tipe": "count_critical", "threshold": 5, "level": 2}]

// Semua variabel baik (min level 4):
[{"tipe": "all_good", "level": 4}]

// Operator yang tersedia: >=, &lt;=, ==, >, &lt;
// Variabel: beban_tugas, tidur, motivasi, sosial, fisik,
//           keuangan, emosi, prestasi, waktu, masa_depan</pre>
            </div>
        </div>
    </div>
</div>
@endsection
