<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiagnosisSession extends Model
{
    protected $fillable = [
        'user_id', 'jawaban', 'total_skor', 'skor_kelelahan',
        'skor_depersonalisasi', 'skor_prestasi', 'kategori_risiko',
        'rule_terpilih', 'rekomendasi', 'cf_hasil', 'penjelasan',
    ];

    protected $casts = [
        'jawaban' => 'array',
        'penjelasan' => 'array',
        'cf_hasil' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBadgeColorAttribute(): string
    {
        return match($this->kategori_risiko) {
            'Rendah' => 'success',
            'Sedang' => 'warning',
            'Tinggi' => 'danger',
            default => 'secondary',
        };
    }

    public function getProgressColorAttribute(): string
    {
        return match($this->kategori_risiko) {
            'Rendah' => '#22c55e',
            'Sedang' => '#f59e0b',
            'Tinggi' => '#ef4444',
            default => '#6b7280',
        };
    }
}
