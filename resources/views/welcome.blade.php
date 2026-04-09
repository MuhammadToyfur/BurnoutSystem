<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BurnoutCheck - Sistem Pakar Burnout Mahasiswa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --secondary: #06b6d4;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* HERO */
        .hero {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #1e40af 100%);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(ellipse at 70% 50%, rgba(99,102,241,0.25) 0%, transparent 60%),
                        radial-gradient(ellipse at 20% 80%, rgba(6,182,212,0.15) 0%, transparent 50%);
        }

        .hero-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
        }

        .blob-1 { width: 500px; height: 500px; background: #818cf8; top: -100px; right: -100px; }
        .blob-2 { width: 350px; height: 350px; background: #22d3ee; bottom: -80px; left: 10%; }

        .navbar-custom {
            background: rgba(255,255,255,0.06);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .hero-title {
            font-family: 'Sora', sans-serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
        }

        .hero-title .accent {
            background: linear-gradient(135deg, #a5b4fc, #67e8f9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-desc {
            color: rgba(255,255,255,0.7);
            font-size: 1.1rem;
            line-height: 1.7;
        }

        .hero-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 0.8rem; color: rgba(255,255,255,0.8);
            margin-bottom: 20px;
        }

        .btn-hero-primary {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border: none; color: #fff;
            padding: 14px 32px; border-radius: 12px;
            font-weight: 700; font-size: 1rem;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex; align-items: center; gap: 8px;
        }

        .btn-hero-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 36px rgba(79,70,229,0.5);
            color: #fff;
        }

        .btn-hero-outline {
            background: transparent;
            border: 1.5px solid rgba(255,255,255,0.3);
            color: rgba(255,255,255,0.85);
            padding: 14px 28px; border-radius: 12px;
            font-weight: 600; font-size: 1rem;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-hero-outline:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
            border-color: rgba(255,255,255,0.5);
        }

        .hero-card {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 24px;
            color: #fff;
        }

        .hero-card .score-ring {
            width: 120px; height: 120px;
            border-radius: 50%;
            background: conic-gradient(#22d3ee 0% 65%, rgba(255,255,255,0.1) 65%);
            display: flex; align-items: center; justify-content: center;
            position: relative; margin: 0 auto 16px;
        }

        .hero-card .score-inner {
            width: 90px; height: 90px;
            background: #1e1b4b; border-radius: 50%;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
        }

        /* FEATURES */
        .section-title {
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            color: #1e293b;
        }

        .feature-card {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 28px;
            background: #fff;
            transition: all 0.2s;
            height: 100%;
        }

        .feature-card:hover {
            border-color: #c7d2fe;
            box-shadow: 0 12px 32px rgba(79,70,229,0.1);
            transform: translateY(-4px);
        }

        .feature-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 16px;
        }

        /* STEPS */
        .step-number {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, var(--primary), #7c3aed);
            border-radius: 50%;
            color: #fff; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; flex-shrink: 0;
        }

        /* FOOTER */
        footer {
            background: #1e1b4b;
            color: rgba(255,255,255,0.6);
            padding: 40px 0;
        }
    </style>
</head>
<body>

{{-- HERO SECTION --}}
<section class="hero">
    <div class="hero-blob blob-1"></div>
    <div class="hero-blob blob-2"></div>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-custom py-3 position-relative">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                <span style="font-size:1.6rem">🧠</span>
                <span style="font-family:'Sora',sans-serif;font-weight:700;color:#fff;font-size:1.2rem">BurnoutCheck</span>
            </a>
            <div class="d-flex gap-2">
                <a href="{{ route('articles.index') }}" class="btn btn-sm" style="color:rgba(255,255,255,0.7);border-radius:8px">Artikel</a>
                @auth
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="btn btn-sm btn-hero-primary" style="padding:8px 18px;font-size:0.85rem">
                        Dashboard <i class="bi bi-arrow-right"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm" style="color:rgba(255,255,255,0.7);border-radius:8px">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-hero-primary" style="padding:8px 18px;font-size:0.85rem">Daftar Gratis</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Hero Content --}}
    <div class="container py-5 position-relative">
        <div class="row align-items-center min-vh-75 py-5">
            <div class="col-lg-6">
                <div class="hero-badge">
                    <span style="color:#22d3ee">●</span> Sistem Berbasis Pengetahuan (SBP)
                </div>
                <h1 class="hero-title mb-4">
                    Deteksi <span class="accent">Burnout</span><br>
                    Sebelum Terlambat
                </h1>
                <p class="hero-desc mb-5">
                    Sistem pakar berbasis aturan IF-THEN yang menganalisis 10 variabel psikologis
                    untuk mendiagnosis risiko burnout mahasiswa secara akurat dan memberikan
                    rekomendasi personal.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    @auth
                        <a href="{{ route('diagnosis.form') }}" class="btn-hero-primary">
                            <i class="bi bi-clipboard2-pulse-fill"></i> Mulai Diagnosis
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-hero-primary">
                            <i class="bi bi-clipboard2-pulse-fill"></i> Mulai Diagnosis
                        </a>
                    @endauth
                    <a href="{{ route('knowledge.index') }}" class="btn-hero-outline">
                        <i class="bi bi-lightbulb me-1"></i> Lihat Knowledge Base
                    </a>
                </div>

                <div class="d-flex gap-4 mt-5">
                    <div>
                        <div style="font-family:'Sora',sans-serif;font-size:1.8rem;font-weight:800;color:#fff">10</div>
                        <div style="font-size:0.78rem;color:rgba(255,255,255,0.5)">Variabel Analisis</div>
                    </div>
                    <div style="width:1px;background:rgba(255,255,255,0.1)"></div>
                    <div>
                        <div style="font-family:'Sora',sans-serif;font-size:1.8rem;font-weight:800;color:#fff">13+</div>
                        <div style="font-size:0.78rem;color:rgba(255,255,255,0.5)">Aturan IF-THEN</div>
                    </div>
                    <div style="width:1px;background:rgba(255,255,255,0.1)"></div>
                    <div>
                        <div style="font-family:'Sora',sans-serif;font-size:1.8rem;font-weight:800;color:#fff">3</div>
                        <div style="font-size:0.78rem;color:rgba(255,255,255,0.5)">Level Risiko</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 offset-lg-1 mt-5 mt-lg-0">
                <div class="hero-card">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <div style="font-size:0.78rem;color:rgba(255,255,255,0.5);margin-bottom:4px">Contoh Hasil Diagnosis</div>
                            <div style="font-weight:600;font-size:1rem">Rizky Mahendra</div>
                        </div>
                        <span style="background:rgba(239,68,68,0.2);color:#fca5a5;padding:5px 12px;border-radius:20px;font-size:0.78rem;font-weight:600">
                            ⚠ Risiko Tinggi
                        </span>
                    </div>
                    <div class="score-ring mb-3">
                        <div class="score-inner">
                            <div style="font-family:'Sora',sans-serif;font-size:1.6rem;font-weight:800;color:#22d3ee">32</div>
                            <div style="font-size:0.65rem;color:rgba(255,255,255,0.4)">/100</div>
                        </div>
                    </div>
                    <div class="text-center mb-4" style="font-size:0.78rem;color:rgba(255,255,255,0.5)">Total Skor Burnout</div>
                    
                    @foreach([['Kelelahan', 25, '#ef4444'], ['Depersonalisasi', 30, '#f59e0b'], ['Prestasi', 40, '#22d3ee']] as [$dim, $pct, $color])
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span style="font-size:0.78rem;color:rgba(255,255,255,0.6)">{{ $dim }}</span>
                            <span style="font-size:0.78rem;color:rgba(255,255,255,0.8)">{{ $pct }}%</span>
                        </div>
                        <div style="height:6px;background:rgba(255,255,255,0.1);border-radius:3px">
                            <div style="width:{{ $pct }}%;height:100%;background:{{ $color }};border-radius:3px;transition:width 0.8s"></div>
                        </div>
                    </div>
                    @endforeach

                    <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);border-radius:10px;padding:12px;margin-top:16px">
                        <div style="font-size:0.75rem;color:rgba(255,255,255,0.7);line-height:1.5">
                            💡 Aturan R01 terpenuhi. Segera konsultasikan dengan konselor kampus...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FEATURES SECTION --}}
<section class="py-5" style="background:#fff">
    <div class="container py-4">
        <div class="text-center mb-5">
            <div style="color:var(--primary);font-weight:600;font-size:0.85rem;margin-bottom:8px">FITUR LENGKAP</div>
            <h2 class="section-title fs-2">Semua yang Anda Butuhkan</h2>
            <p class="text-muted" style="max-width:500px;margin:0 auto">Platform komprehensif untuk memantau dan mengelola kesehatan mental akademik mahasiswa.</p>
        </div>
        <div class="row g-4">
            @foreach([
                ['🩺', '#ede9fe', 'Diagnosis Burnout', 'Form 10 variabel dengan rule-based engine. Input jawaban Anda dan dapatkan hasil diagnosis instan berbasis SBP.'],
                ['📊', '#e0f2fe', 'Visualisasi Skor', 'Lihat skor per dimensi (Kelelahan, Depersonalisasi, Prestasi) dalam tampilan grafik yang informatif.'],
                ['💡', '#fef3c7', 'Rekomendasi Personal', 'Saran yang disesuaikan dengan profil burnout Anda berdasarkan aturan IF-THEN yang telah dikurasi pakar.'],
                ['📄', '#dcfce7', 'Cetak Laporan PDF', 'Export hasil diagnosis lengkap ke format PDF untuk keperluan konsultasi dengan konselor kampus.'],
                ['🗂️', '#fce7f3', 'Knowledge Base', 'Lihat seluruh aturan IF-THEN yang digunakan sistem untuk memahami logika diagnosis burnout.'],
                ['📚', '#f0fdf4', 'Artikel Edukasi', 'Koleksi artikel tips, informasi, dan strategi pencegahan burnout yang dikurasi oleh para ahli.'],
            ] as [$icon, $bg, $title, $desc])
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background:{{ $bg }}">{{ $icon }}</div>
                    <h5 style="font-family:'Sora',sans-serif;font-weight:700;margin-bottom:8px">{{ $title }}</h5>
                    <p class="text-muted mb-0" style="font-size:0.875rem;line-height:1.6">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- HOW IT WORKS --}}
<section class="py-5" style="background:#f8fafc">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="section-title fs-2">Cara Kerja Sistem</h2>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach([
                ['1', 'Isi Form Diagnosis', 'Jawab 10 pertanyaan tentang kondisi akademik dan psikologis Anda dengan skala 1-5.', 'bi-clipboard2-check'],
                ['2', 'Mesin Inferensi SBP', 'Sistem mengevaluasi jawaban menggunakan Forward Chaining dengan 13+ aturan IF-THEN.', 'bi-cpu'],
                ['3', 'Lihat Hasil & Rekomendasi', 'Dapatkan kategori risiko, skor detail, dan rekomendasi personal berbasis aturan pakar.', 'bi-bar-chart-fill'],
            ] as [$num, $title, $desc, $icon])
            <div class="col-md-4">
                <div class="d-flex gap-3 align-items-start">
                    <div class="step-number">{{ $num }}</div>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi {{ $icon }}" style="color:var(--primary)"></i>
                            <h5 class="mb-0" style="font-weight:700">{{ $title }}</h5>
                        </div>
                        <p class="text-muted mb-0" style="font-size:0.875rem">{{ $desc }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-5" style="background:linear-gradient(135deg,#4f46e5,#1e40af)">
    <div class="container text-center py-4">
        <h2 style="font-family:'Sora',sans-serif;font-weight:800;color:#fff;margin-bottom:16px">Cek Status Burnout Anda Sekarang</h2>
        <p style="color:rgba(255,255,255,0.75);margin-bottom:32px">Gratis, anonim, dan hanya butuh 3 menit. Deteksi dini adalah kunci pemulihan.</p>
        @auth
            <a href="{{ route('diagnosis.form') }}" class="btn-hero-primary">
                <i class="bi bi-clipboard2-pulse-fill"></i> Mulai Diagnosis
            </a>
        @else
            <a href="{{ route('register') }}" class="btn-hero-primary">
                <i class="bi bi-person-plus-fill"></i> Daftar & Mulai Sekarang
            </a>
        @endauth
    </div>
</section>

<footer>
    <div class="container text-center">
        <div style="font-family:'Sora',sans-serif;font-weight:700;color:#fff;font-size:1.1rem;margin-bottom:8px">🧠 BurnoutCheck</div>
        <p style="font-size:0.8rem;margin-bottom:0">Sistem Pakar Berbasis Pengetahuan untuk Deteksi Burnout Mahasiswa</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
