{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - BurnoutCheck</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; min-height: 100vh; display: flex; align-items: center; }
        .auth-container { max-width: 440px; width: 100%; margin: 0 auto; padding: 20px; }
        .auth-card { background: #fff; border-radius: 20px; padding: 40px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .brand { text-align: center; margin-bottom: 32px; }
        .brand-icon { width: 56px; height: 56px; background: linear-gradient(135deg, #4f46e5, #06b6d4); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 12px; }
        .brand h1 { font-family: 'Sora', sans-serif; font-size: 1.5rem; font-weight: 800; color: #1e293b; margin: 0 0 4px; }
        .brand p { color: #64748b; font-size: 0.85rem; margin: 0; }
        .form-label { font-weight: 600; font-size: 0.85rem; color: #374151; }
        .form-control { border-radius: 10px; border-color: #e2e8f0; padding: 11px 14px; font-size: 0.9rem; transition: all 0.2s; }
        .form-control:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.1); }
        .btn-login { background: linear-gradient(135deg, #4f46e5, #3730a3); border: none; width: 100%; padding: 13px; border-radius: 10px; font-weight: 700; font-size: 0.95rem; color: #fff; cursor: pointer; transition: all 0.2s; }
        .btn-login:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(79,70,229,0.35); }
        .divider { text-align: center; margin: 20px 0; color: #94a3b8; font-size: 0.8rem; position: relative; }
        .divider::before, .divider::after { content: ''; position: absolute; top: 50%; width: 42%; height: 1px; background: #e2e8f0; }
        .divider::before { left: 0; } .divider::after { right: 0; }
    </style>
</head>
<body>
<div class="auth-container">
    <div class="brand-simple text-center mb-4">
        <a href="{{ route('home') }}" style="text-decoration:none;color:#64748b;font-size:0.8rem">← Kembali ke Beranda</a>
    </div>
    <div class="auth-card">
        <div class="brand">
            <div class="brand-icon">🧠</div>
            <h1>Masuk ke BurnoutCheck</h1>
            <p>Masukkan email dan password Anda</p>
        </div>

        @if($errors->any())
        <div class="alert alert-danger alert-sm mb-3" style="border-radius:10px;font-size:0.85rem">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <div class="form-check mb-4">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember" style="font-size:0.85rem;color:#64748b">Ingat saya</label>
            </div>
            <button type="submit" class="btn-login">Masuk <i class="bi bi-arrow-right ms-1"></i></button>
        </form>

        <div class="divider">atau</div>
        <div class="text-center" style="font-size:0.85rem;color:#64748b">
            Belum punya akun? <a href="{{ route('register') }}" style="color:#4f46e5;font-weight:600">Daftar Sekarang</a>
        </div>

        <div class="text-center mt-3" style="font-size:0.75rem;color:#94a3b8">
            Demo: admin@burnout.ac.id / admin123 (Admin)<br>
            budi@mahasiswa.ac.id / password (Mahasiswa)
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
