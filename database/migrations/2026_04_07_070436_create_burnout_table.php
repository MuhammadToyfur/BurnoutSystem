<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel aturan IF-THEN
        Schema::create('diagnosis_rules', function (Blueprint $table) {
            $table->id();
            $table->string('rule_code')->unique(); // R01, R02, ...
            $table->text('kondisi'); // deskripsi kondisi
            $table->json('kondisi_json'); // array kondisi terstruktur
            $table->enum('hasil_risiko', ['Rendah', 'Sedang', 'Tinggi']);
            $table->text('rekomendasi');
            $table->integer('bobot')->default(1);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // Tabel sesi diagnosis
        Schema::create('diagnosis_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('jawaban'); // 10 variabel input
            $table->integer('total_skor'); // 0-100
            $table->integer('skor_kelelahan');
            $table->integer('skor_depersonalisasi');
            $table->integer('skor_prestasi');
            $table->enum('kategori_risiko', ['Rendah', 'Sedang', 'Tinggi']);
            $table->string('rule_terpilih')->nullable();
            $table->text('rekomendasi');
            $table->timestamps();
        });

        // Tabel artikel edukasi
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('konten');
            $table->string('kategori'); // tips, info, pencegahan
            $table->string('thumbnail')->nullable();
            $table->boolean('published')->default(true);
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
        Schema::dropIfExists('diagnosis_sessions');
        Schema::dropIfExists('diagnosis_rules');
    }
};
