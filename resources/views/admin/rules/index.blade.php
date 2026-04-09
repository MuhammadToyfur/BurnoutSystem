@extends('layouts.app')
@section('title', 'Kelola Aturan')
@section('page-title', 'Kelola Aturan IF-THEN')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" style="color:#4f46e5;text-decoration:none">Dashboard</a></li>
    <li class="breadcrumb-item active">Aturan</li>
@endsection

@section('topbar-actions')
    <a href="{{ route('admin.rules.create') }}" class="btn-primary-custom">
        <i class="bi bi-plus-circle-fill"></i> Tambah Aturan
    </a>
@endsection

@section('content')
@if(session('success'))
<div class="alert alert-success mb-4"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header"><i class="bi bi-diagram-3-fill me-2" style="color:#4f46e5"></i>Semua Aturan Inferensi</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Kondisi IF</th>
                        <th>Hasil THEN</th>
                        <th>Bobot</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rules as $rule)
                    <tr style="{{ !$rule->aktif ? 'opacity:0.5' : '' }}">
                        <td><code style="background:#f1f5f9;padding:3px 8px;border-radius:5px;font-weight:700">{{ $rule->rule_code }}</code></td>
                        <td style="font-size:0.82rem;max-width:280px">
                            <div style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $rule->kondisi }}</div>
                        </td>
                        <td>
                            <span class="badge-risiko badge-{{ strtolower($rule->hasil_risiko) }}">{{ $rule->hasil_risiko }}</span>
                        </td>
                        <td style="font-weight:700;color:#4f46e5">{{ $rule->bobot }}/10</td>
                        <td>
                            <form action="{{ route('admin.rules.toggle', $rule) }}" method="POST" style="display:inline">
                                @csrf
                                <button type="submit" style="background:{{ $rule->aktif ? '#dcfce7' : '#fee2e2' }};color:{{ $rule->aktif ? '#16a34a' : '#dc2626' }};border:none;padding:3px 10px;border-radius:10px;font-size:0.75rem;font-weight:600;cursor:pointer">
                                    {{ $rule->aktif ? '● Aktif' : '○ Nonaktif' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.rules.edit', $rule) }}" style="font-size:0.78rem;background:#fef3c7;color:#d97706;padding:4px 9px;border-radius:6px;text-decoration:none;font-weight:600">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.rules.destroy', $rule) }}" method="POST" onsubmit="return confirm('Hapus aturan {{ $rule->rule_code }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="font-size:0.78rem;background:#fee2e2;color:#dc2626;padding:4px 9px;border-radius:6px;border:none;font-weight:600;cursor:pointer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @if($rules->hasPages())
    <div class="card-footer d-flex justify-content-center py-3">{{ $rules->links() }}</div>
    @endif
</div>
@endsection
