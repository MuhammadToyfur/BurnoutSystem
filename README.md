<<<<<<< HEAD
# 🧠 BurnoutCheck — Sistem Pakar Burnout Mahasiswa

**Sistem Berbasis Pengetahuan (SBP)** untuk mendiagnosis risiko burnout mahasiswa menggunakan metode **Forward Chaining Rule-Based System** dengan 10 variabel psikologis dan 13+ aturan IF-THEN.

---

## 📋 Fitur Lengkap

| # | Fitur | Deskripsi |
|---|-------|-----------|
| 1 | Halaman Utama | Landing page & penjelasan sistem |
| 2 | Login / Register | Autentikasi & profil mahasiswa |
| 3 | Dashboard | Ringkasan status & riwayat terkini |
| 4 | Form Diagnosis Burnout | Input 10 variabel → rule-based → output risiko |
| 5 | Hasil Diagnosis | Skor, kategori risiko, radar chart visualisasi |
| 6 | Rekomendasi | Saran personal berbasis aturan |
| 7 | Cetak Laporan PDF | Export hasil diagnosis ke PDF |
| 8 | Riwayat Diagnosis | Histori & perbandingan antar waktu (line chart) |
| 9 | Knowledge Base | Tampil aturan IF-THEN sistem |
| 10 | Artikel Edukasi | Tips & info seputar burnout |
| 11 | Kelola Pengguna | CRUD data mahasiswa (Admin) |
| 12 | Kelola Aturan | Tambah/edit/hapus rule IF-THEN (Admin) |
| 13 | Statistik & Laporan | Grafik distribusi risiko mahasiswa (Admin) |

---

## 🧠 Mesin Inferensi SBP

### Metode: Forward Chaining
- Data fakta (10 variabel input) dievaluasi terhadap semua aturan aktif
- Strategi: **First-Match** (aturan dengan bobot tertinggi dievaluasi lebih dulu)
- Output: Kategori Risiko (Rendah/Sedang/Tinggi) + Rekomendasi

### 10 Variabel Input (Skala 1-5)
| No | Variabel | Dimensi MBI | Bobot SBP |
|----|----------|-------------|-----------|
| 1 | `beban_tugas` | Kelelahan | 1.2 |
| 2 | `tidur` | Kelelahan | 1.3 |
| 3 | `motivasi` | Prestasi | 1.1 |
| 4 | `sosial` | Depersonalisasi | 1.0 |
| 5 | `fisik` | Kelelahan | 1.1 |
| 6 | `keuangan` | Kelelahan | 0.9 |
| 7 | `emosi` | Depersonalisasi | 1.2 |
| 8 | `prestasi` | Prestasi | 1.0 |
| 9 | `waktu` | Prestasi | 1.0 |
| 10 | `masa_depan` | Depersonalisasi | 0.9 |

### Framework MBI (Maslach Burnout Inventory)
3 Dimensi: Kelelahan Emosional · Depersonalisasi · Penurunan Prestasi

---

## 🚀 Instalasi

### Persyaratan
- PHP 8.1+
- Composer 2.x
- MySQL 8.0+ / MariaDB 10.4+
- Node.js 18+ (opsional, untuk asset)

### Langkah Instalasi

```bash
# 1. Clone atau buat project Laravel baru
composer create-project laravel/laravel burnout-sistem
cd burnout-sistem

# 2. Install dependensi
composer require barryvdh/laravel-dompdf

# 3. Salin semua file dari folder ini ke struktur Laravel
# Ikuti struktur folder yang telah disediakan

# 4. Konfigurasi .env
cp .env.example .env
php artisan key:generate

# Edit .env:
# DB_DATABASE=burnout_db
# DB_USERNAME=root
# DB_PASSWORD=yourpassword

# 5. Buat database
mysql -u root -p -e "CREATE DATABASE burnout_db;"

# 6. Jalankan migrasi dan seeder
php artisan migrate --seed

# 7. Jalankan server
php artisan serve
```

### Akun Demo
| Role | Email | Password |
|------|-------|----------|
| Admin | admin@burnout.ac.id | admin123 |
| Mahasiswa | budi@mahasiswa.ac.id | password |

---

## 📁 Struktur File

```
app/
├── Http/
│   └── Controllers/
│       ├── AuthController.php
│       ├── DashboardController.php
│       ├── DiagnosisController.php
│       ├── HistoryController.php
│       ├── KnowledgeController.php
│       ├── ArticleController.php
│       └── Admin/
│           ├── AdminDashboardController.php
│           ├── UserController.php
│           └── RuleController.php
├── Models/
│   ├── User.php
│   ├── DiagnosisRule.php
│   ├── DiagnosisSession.php
│   └── Article.php
└── Services/
    └── BurnoutExpertService.php  ← MESIN INFERENSI UTAMA

database/
├── migrations/
│   ├── 2024_01_01_000001_create_users_table.php
│   └── 2024_01_01_000002_create_burnout_tables.php
└── seeders/
    └── DatabaseSeeder.php

resources/views/
├── layouts/app.blade.php
├── welcome.blade.php
├── auth/{login,register}.blade.php
├── dashboard/index.blade.php
├── diagnosis/{form,hasil,pdf}.blade.php
├── history/index.blade.php
├── knowledge/index.blade.php
├── articles/{index,show}.blade.php
└── admin/
    ├── dashboard.blade.php
    ├── users/{index,show}.blade.php
    └── rules/{index,form}.blade.php

routes/web.php
```

---

## 🔧 Konfigurasi Tambahan (config/app.php)

```php
// Tambahkan provider untuk DomPDF
'providers' => [
    // ...
    Barryvdh\DomPDF\ServiceProvider::class,
],
'aliases' => [
    // ...
    'Pdf' => Barryvdh\DomPDF\Facade\Pdf::class,
],
```

---

## 🎨 Tech Stack

- **Backend**: Laravel 10, PHP 8.1+
- **Database**: MySQL (Eloquent ORM)
- **PDF**: barryvdh/laravel-dompdf
- **Frontend**: Bootstrap 5.3, Bootstrap Icons
- **Charts**: Chart.js 4
- **Fonts**: Plus Jakarta Sans + Sora (Google Fonts)

---

*Sistem Pakar Burnout Mahasiswa · Berbasis SBP Forward Chaining*
=======
# BurnoutSystem
>>>>>>> 1884485872bf1cd7b49c53bb0a5e0df70fedd5c4
