<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BurnoutCheck') - Sistem Pakar Burnout Mahasiswa</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Sora:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #818cf8;
            --primary-dark: #3730a3;
            --secondary: #06b6d4;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --bg: #f8fafc;
            --sidebar-bg: #1e1b4b;
            --sidebar-width: 260px;
            --card-radius: 16px;
            --font-main: 'Plus Jakarta Sans', sans-serif;
            --font-display: 'Sora', sans-serif;
        }

        * { box-sizing: border-box; }
        
        body {
            font-family: var(--font-main);
            background: var(--bg);
            color: #1e293b;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            min-height: 100vh;
            position: fixed;
            left: 0; top: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-brand .brand-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--primary-light), var(--secondary));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; margin-bottom: 10px;
        }

        .sidebar-brand h1 {
            font-family: var(--font-display);
            font-size: 1.3rem;
            font-weight: 700;
            color: #fff;
            margin: 0;
        }

        .sidebar-brand p {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.45);
            margin: 2px 0 0;
        }

        .sidebar-nav {
            padding: 16px 12px;
            flex: 1;
            overflow-y: auto;
        }

        .nav-section-label {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(255,255,255,0.3);
            padding: 12px 8px 6px;
        }

        .nav-item a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
            margin-bottom: 2px;
        }

        .nav-item a:hover,
        .nav-item a.active {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }

        .nav-item a.active {
            background: linear-gradient(135deg, rgba(79,70,229,0.5), rgba(6,182,212,0.3));
            color: #fff;
        }

        .nav-item a i { font-size: 1rem; width: 20px; text-align: center; }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .user-info {
            display: flex; align-items: center; gap: 10px;
            padding: 10px;
            background: rgba(255,255,255,0.06);
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .user-avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--primary-light), var(--secondary));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; color: #fff; font-size: 0.85rem;
            flex-shrink: 0;
        }

        .user-info .user-name {
            font-size: 0.8rem; font-weight: 600; color: #fff;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }

        .user-info .user-role {
            font-size: 0.68rem; color: rgba(255,255,255,0.4);
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
        }

        .topbar h2 {
            font-family: var(--font-display);
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }

        .topbar .breadcrumb {
            font-size: 0.78rem;
            margin: 0;
        }

        .page-body {
            padding: 28px;
            flex: 1;
        }

        /* ===== CARDS ===== */
        .card {
            border: none;
            border-radius: var(--card-radius);
            box-shadow: 0 1px 3px rgba(0,0,0,0.07), 0 4px 12px rgba(0,0,0,0.04);
            background: #fff;
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid #f1f5f9;
            padding: 18px 20px;
            font-weight: 600;
        }

        .stat-card {
            border-radius: var(--card-radius);
            padding: 20px;
            border: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.07);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }

        .stat-card .stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 14px;
        }

        .stat-card .stat-value {
            font-family: var(--font-display);
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 4px;
        }

        .stat-card .stat-label {
            font-size: 0.78rem;
            color: #64748b;
            font-weight: 500;
        }

        /* ===== BADGES ===== */
        .badge-risiko {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 10px; border-radius: 20px;
            font-size: 0.75rem; font-weight: 600;
        }

        .badge-rendah { background: #dcfce7; color: #16a34a; }
        .badge-sedang { background: #fef3c7; color: #d97706; }
        .badge-tinggi { background: #fee2e2; color: #dc2626; }

        /* ===== PROGRESS BARS ===== */
        .progress {
            height: 8px;
            border-radius: 4px;
            background: #f1f5f9;
        }

        .progress-bar { border-radius: 4px; }

        /* ===== BUTTONS ===== */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            color: #fff;
            padding: 10px 22px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s;
            display: inline-flex; align-items: center; gap: 6px;
        }

        .btn-primary-custom:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(79,70,229,0.35);
            color: #fff;
        }

        /* ===== ALERTS ===== */
        .alert {
            border: none;
            border-radius: 10px;
            font-size: 0.875rem;
        }

        /* ===== TABLES ===== */
        .table { font-size: 0.875rem; }
        .table th { font-weight: 600; color: #64748b; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.04em; }
        .table td { vertical-align: middle; }

        /* ===== MOBILE TOGGLE ===== */
        .sidebar-toggle {
            display: none;
            background: none; border: none;
            font-size: 1.3rem; color: #475569;
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .sidebar-toggle { display: block; }
            .page-body { padding: 16px; }
            .topbar { padding: 12px 16px; }
        }

        /* ===== SCROLLBAR ===== */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }

        /* ===== ANIMATIONS ===== */
        .fade-in { animation: fadeIn 0.4s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
    </style>
    
    @yield('styles')
</head>
<body>

{{-- SIDEBAR --}}
<nav class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">🧠</div>
        <h1>BurnoutCheck</h1>
        <p>Sistem Pakar Mahasiswa</p>
    </div>

    <div class="sidebar-nav">
        @auth
            @if(auth()->user()->isAdmin())
                {{-- Admin Navigation --}}
                <div class="nav-section-label">Admin Panel</div>
                <div class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2-fill"></i> Dashboard Admin
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i> Kelola Pengguna
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.rules.index') }}" class="{{ request()->routeIs('admin.rules*') ? 'active' : '' }}">
                        <i class="bi bi-diagram-3-fill"></i> Kelola Aturan
                    </a>
                </div>
            @else
                {{-- Mahasiswa Navigation --}}
                <div class="nav-section-label">Menu Utama</div>
                <div class="nav-item">
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-house-fill"></i> Dashboard
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('diagnosis.form') }}" class="{{ request()->routeIs('diagnosis.form') ? 'active' : '' }}">
                        <i class="bi bi-clipboard2-pulse-fill"></i> Mulai Diagnosis
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('history.index') }}" class="{{ request()->routeIs('history*') ? 'active' : '' }}">
                        <i class="bi bi-clock-history"></i> Riwayat Diagnosis
                    </a>
                </div>
                <div class="nav-section-label">Edukasi</div>
                <div class="nav-item">
                    <a href="{{ route('knowledge.index') }}" class="{{ request()->routeIs('knowledge*') ? 'active' : '' }}">
                        <i class="bi bi-lightbulb-fill"></i> Knowledge Base
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('articles.index') }}" class="{{ request()->routeIs('articles*') ? 'active' : '' }}">
                        <i class="bi bi-newspaper"></i> Artikel Edukasi
                    </a>
                </div>
            @endif
        @endauth
    </div>

    @auth
    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div style="overflow:hidden">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm w-100" style="background:rgba(255,255,255,0.07);color:rgba(255,255,255,0.6);border-radius:8px;font-size:0.8rem;padding:7px">
                <i class="bi bi-box-arrow-right me-1"></i> Keluar
            </button>
        </form>
    </div>
    @endauth
</nav>

{{-- MAIN CONTENT --}}
<div class="main-content">
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="sidebar-toggle" id="sidebarToggle"><i class="bi bi-list"></i></button>
            <div>
                <h2>@yield('page-title', 'Dashboard')</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        @yield('breadcrumb')
                    </ol>
                </nav>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            @yield('topbar-actions')
        </div>
    </div>

    <div class="page-body fade-in">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    // Sidebar toggle for mobile
    document.getElementById('sidebarToggle')?.addEventListener('click', function () {
        document.getElementById('sidebar').classList.toggle('open');
    });
</script>

@yield('scripts')
</body>
</html>
