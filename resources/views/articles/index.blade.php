{{-- resources/views/articles/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Artikel Edukasi')
@section('page-title', 'Artikel Edukasi')

@section('breadcrumb')
    <li class="breadcrumb-item active">Artikel</li>
@endsection

@section('content')
<div class="row g-4 mb-4">
    {{-- Filter --}}
    <div class="col-12">
        <div class="card">
            <div class="card-body p-3 d-flex flex-wrap gap-2 align-items-center">
                <span style="font-size:0.82rem;font-weight:600;color:#475569">Filter:</span>
                <a href="{{ route('articles.index') }}" class="filter-pill {{ !request('kategori') ? 'active' : '' }}">Semua</a>
                <a href="{{ route('articles.index', ['kategori'=>'tips']) }}" class="filter-pill {{ request('kategori')==='tips' ? 'active' : '' }}">💡 Tips</a>
                <a href="{{ route('articles.index', ['kategori'=>'info']) }}" class="filter-pill {{ request('kategori')==='info' ? 'active' : '' }}">ℹ️ Informasi</a>
                <a href="{{ route('articles.index', ['kategori'=>'pencegahan']) }}" class="filter-pill {{ request('kategori')==='pencegahan' ? 'active' : '' }}">🛡️ Pencegahan</a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    @forelse($articles as $article)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 article-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;padding:3px 10px;border-radius:10px;background:
                        {{ $article->kategori==='tips'?'#ede9fe':($article->kategori==='info'?'#e0f2fe':'#dcfce7') }};
                        color:{{ $article->kategori==='tips'?'#4f46e5':($article->kategori==='info'?'#0284c7':'#16a34a') }}">
                        {{ $article->kategori }}
                    </span>
                </div>
                <h5 style="font-weight:700;color:#1e293b;font-size:1rem;margin-bottom:10px;line-height:1.4">
                    {{ $article->judul }}
                </h5>
                <p style="font-size:0.82rem;color:#64748b;line-height:1.6;margin-bottom:16px">
                    {{ $article->excerpt }}
                </p>
            </div>
            <div class="card-footer" style="background:transparent;border-top:1px solid #f1f5f9;padding:14px 20px">
                <div class="d-flex align-items-center justify-content-between">
                    <span style="font-size:0.75rem;color:#94a3b8">
                        <i class="bi bi-calendar3 me-1"></i>{{ $article->created_at->format('d M Y') }}
                    </span>
                    <a href="{{ route('articles.show', $article->slug) }}" style="font-size:0.8rem;color:#4f46e5;font-weight:600;text-decoration:none">
                        Baca Selengkapnya <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card">
            <div class="card-body p-5 text-center">
                <div style="font-size:3rem;margin-bottom:12px">📰</div>
                <p style="color:#64748b">Belum ada artikel tersedia.</p>
            </div>
        </div>
    </div>
    @endforelse
</div>

@if($articles->hasPages())
<div class="d-flex justify-content-center mt-4">{{ $articles->links() }}</div>
@endif
@endsection

@section('styles')
<style>
.filter-pill { padding:6px 14px;border-radius:20px;font-size:0.8rem;font-weight:600;background:#f1f5f9;color:#475569;text-decoration:none;transition:all 0.15s; }
.filter-pill:hover,.filter-pill.active { background:#4f46e5;color:#fff; }
.article-card { transition:all 0.2s; }
.article-card:hover { transform:translateY(-3px);box-shadow:0 8px 28px rgba(0,0,0,0.1); }
</style>
@endsection
