@extends('layouts.app')
@section('title', 'Detail Pengguna')
@section('page-title', 'Detail Pengguna')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" style="color:#4f46e5;text-decoration:none">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" style="color:#4f46e5;text-decoration:none">Pengguna</a></li>
    <li class="breadcrumb-item active">{{ $user->name }}</li>
@endsection

@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body p-4 text-center">
                <div style="width:72px;height:72px;background:linear-gradient(135deg,#4f46e5,#06b6d4);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:1.5rem;margin:0 auto 16px">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h5 style="font-weight:700;color:#1e293b;margin-bottom:4px">{{ $user->name }}</h5>
                <p style="color:#64748b;font-size:0.85rem;margin-bottom:16px">{{ $user->email }}</p>
                <div style="background:#f8fafc;border-radius:10px;padding:14px;text-align:left">
                    @foreach([['NIM', $user->nim ?? '-'], ['Program Studi', $user->jurusan ?? '-'], ['Angkatan', $user->angkatan ?? '-'], ['Bergabung', $user->created_at->format('d M Y')]] as [$lbl, $val])
                    <div class="d-flex justify-content-between py-2" style="{{ !$loop->last ? 'border-bottom:1px solid #e2e8f0' : '' }}">
                        <span style="font-size:0.78rem;color:#94a3b8">{{ $lbl }}</span>
                        <span style="font-size:0.82rem;font-weight:600;color:#374151">{{ $val }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><i class="bi bi-clock-history me-2" style="color:#4f46e5"></i>Riwayat Diagnosis</div>
            <div class="card-body p-0">
                @forelse($sessions as $s)
                <div class="d-flex align-items-center gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div style="width:40px;height:40px;border-radius:10px;background:{{ $s->kategori_risiko==='Rendah'?'#dcfce7':($s->kategori_risiko==='Sedang'?'#fef3c7':'#fee2e2') }};display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0">
                        {{ $s->kategori_risiko==='Rendah'?'✅':($s->kategori_risiko==='Sedang'?'⚡':'⚠️') }}
                    </div>
                    <div class="flex-1">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span style="font-weight:700;font-size:0.9rem">Skor: {{ $s->total_skor }}/100</span>
                            <span class="badge-risiko badge-{{ strtolower($s->kategori_risiko) }}">{{ $s->kategori_risiko }}</span>
                        </div>
                        <div style="font-size:0.75rem;color:#94a3b8">{{ $s->created_at->format('d F Y, H:i') }}</div>
                    </div>
                    <a href="{{ route('diagnosis.hasil', $s->id) }}" style="font-size:0.78rem;color:#4f46e5;text-decoration:none;font-weight:600">Detail</a>
                </div>
                @empty
                <div class="p-4 text-center" style="color:#94a3b8;font-size:0.85rem">Belum ada riwayat</div>
                @endforelse
            </div>
            @if($sessions->hasPages())
            <div class="card-footer d-flex justify-content-center py-3">{{ $sessions->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
