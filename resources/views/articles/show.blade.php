@extends('layouts.app')

@section('title', $article->judul)
@section('page-title', 'Artikel Edukasi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('articles.index') }}" style="color:#4f46e5;text-decoration:none">Artikel</a></li>
    <li class="breadcrumb-item active">{{ Str::limit($article->judul, 40) }}</li>
@endsection

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body p-5">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;padding:3px 10px;border-radius:10px;background:#ede9fe;color:#4f46e5">
                        {{ $article->kategori }}
                    </span>
                </div>
                <h1 style="font-family:'Sora',sans-serif;font-size:1.6rem;font-weight:700;color:#1e293b;line-height:1.35;margin-bottom:16px">
                    {{ $article->judul }}
                </h1>
                <div class="d-flex align-items-center gap-3 pb-4 mb-4" style="border-bottom:1px solid #f1f5f9">
                    <div style="width:34px;height:34px;background:linear-gradient(135deg,#4f46e5,#06b6d4);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.82rem">
                        {{ strtoupper(substr($article->author->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size:0.82rem;font-weight:600;color:#374151">{{ $article->author->name }}</div>
                        <div style="font-size:0.75rem;color:#94a3b8">{{ $article->created_at->format('d F Y') }}</div>
                    </div>
                </div>
                <div style="font-size:0.92rem;color:#374151;line-height:1.85;margin-bottom:30px">
                    {!! nl2br(e($article->konten)) !!}
                </div>

                @if($article->source_url)
                <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:20px;display:flex;align-items:flex-start;gap:15px">
                    <div style="font-size:1.5rem;color:#64748b">📚</div>
                    <div>
                        <div style="font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:4px">Referensi Jurnal</div>
                        <div style="font-size:0.875rem;color:#1e293b;font-weight:600;margin-bottom:8px">{{ $article->source_name ?? 'Website Resmi Jurnal' }}</div>
                        <a href="{{ $article->source_url }}" target="_blank" class="btn btn-sm" style="background:#fff;border:1px solid #e2e8f0;color:#4f46e5;font-weight:600;font-size:0.78rem;padding:6px 12px;border-radius:8px;text-decoration:none">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Baca Sumber Asli
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        {{-- CTA Diagnosis --}}
        <div class="card mb-4" style="background:linear-gradient(135deg,#4f46e5,#3730a3)">
            <div class="card-body p-4 text-center">
                <div style="font-size:2rem;margin-bottom:10px">🩺</div>
                <h5 style="font-family:'Sora',sans-serif;color:#fff;font-weight:700;margin-bottom:8px">Cek Kondisi Anda</h5>
                <p style="color:rgba(255,255,255,0.7);font-size:0.82rem;margin-bottom:16px">Lakukan diagnosis burnout gratis sekarang</p>
                <a href="{{ route('diagnosis.form') }}" style="background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);color:#fff;padding:9px 20px;border-radius:9px;text-decoration:none;font-size:0.85rem;font-weight:600;display:block">
                    Mulai Diagnosis <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
        {{-- Related --}}
        @if($related->count())
        <div class="card">
            <div class="card-header"><i class="bi bi-journals me-2" style="color:#4f46e5"></i>Artikel Terkait</div>
            <div class="card-body p-0">
                @foreach($related as $rel)
                <a href="{{ route('articles.show', $rel->slug) }}" style="display:block;padding:14px 16px;border-bottom:{{ !$loop->last ? '1px solid #f1f5f9' : 'none' }};text-decoration:none">
                    <div style="font-size:0.82rem;font-weight:600;color:#1e293b;margin-bottom:4px;line-height:1.4">{{ $rel->judul }}</div>
                    <div style="font-size:0.73rem;color:#94a3b8">{{ $rel->created_at->format('d M Y') }}</div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
