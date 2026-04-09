<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - BurnoutCheck</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Sora:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; min-height: 100vh; padding: 30px 0; }
        .auth-container { max-width: 520px; width: 100%; margin: 0 auto; padding: 20px; }
        .auth-card { background: #fff; border-radius: 20px; padding: 40px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .brand { text-align: center; margin-bottom: 28px; }
        .brand-icon { width: 52px; height: 52px; background: linear-gradient(135deg, #4f46e5, #06b6d4); border-radius: 13px; display: flex; align-items: center; justify-content: center; font-size: 22px; margin: 0 auto 10px; }
        .brand h1 { font-family: 'Sora', sans-serif; font-size: 1.4rem; font-weight: 800; color: #1e293b; margin: 0 0 4px; }
        .brand p { color: #64748b; font-size: 0.85rem; margin: 0; }
        .form-label { font-weight: 600; font-size: 0.83rem; color: #374151; }
        .form-control, .form-select { border-radius: 10px; border-color: #e2e8f0; padding: 10px 14px; font-size: 0.88rem; transition: all 0.2s; }
        .form-control:focus, .form-select:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.1); }
        .btn-register { background: linear-gradient(135deg, #4f46e5, #3730a3); border: none; width: 100%; padding: 12px; border-radius: 10px; font-weight: 700; font-size: 0.95rem; color: #fff; cursor: pointer; transition: all 0.2s; }
        .btn-register:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(79,70,229,0.35); }
        .section-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #4f46e5; padding: 0 0 8px; margin-top: 8px; border-bottom: 1px solid #e0e7ff; margin-bottom: 16px; }
    </style>
</head>
<body>
<div class="auth-container">
    <div class="text-center mb-3">
        <a href="{{ route('home') }}" style="text-decoration:none;color:#64748b;font-size:0.8rem">← Kembali ke Beranda</a>
    </div>
    <div class="auth-card">
        <div class="brand">
            <div class="brand-icon">🧠</div>
            <h1>Buat Akun BurnoutCheck</h1>
            <p>Daftar gratis, mulai cek burnout Anda hari ini</p>
        </div>

        @if($errors->any())
        <div class="alert alert-danger mb-3" style="border-radius:10px;font-size:0.85rem">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="section-label">Data Diri</div>
            <div class="mb-3">
                <label class="form-label">Nama Lengkap <span style="color:#ef4444">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" placeholder="Nama lengkap Anda" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Email <span style="color:#ef4444">*</span></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" placeholder="email@domain.com" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="section-label">Data Akademik (Opsional)</div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">NIM</label>
                    <input type="text" name="nim" class="form-control" value="{{ old('nim') }}" placeholder="2021001001">
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Angkatan</label>
                    <input type="text" name="angkatan" class="form-control" value="{{ old('angkatan') }}" placeholder="2021">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Program Studi</label>
                <input type="text" name="jurusan" class="form-control" value="{{ old('jurusan') }}" placeholder="Teknik Informatika">
            </div>

            <div class="section-label">Keamanan</div>
            <div class="mb-3">
                <label class="form-label">Password <span style="color:#ef4444">*</span></label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="Minimal 6 karakter" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label">Konfirmasi Password <span style="color:#ef4444">*</span></label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
            </div>

            <button type="submit" class="btn-register">
                <i class="bi bi-person-check-fill me-1"></i> Buat Akun Sekarang
            </button>
        </form>

        <div class="text-center mt-4" style="font-size:0.85rem;color:#64748b">
            Sudah punya akun? <a href="{{ route('login') }}" style="color:#4f46e5;font-weight:600">Masuk</a>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
