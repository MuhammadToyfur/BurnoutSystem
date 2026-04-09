<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiagnosisRule extends Model
{
    protected $fillable = [
        'rule_code', 'kondisi', 'kondisi_json', 'hasil_risiko',
        'rekomendasi', 'bobot', 'certainty_factor', 'aktif',
    ];

    protected $casts = [
        'kondisi_json' => 'array',
        'aktif' => 'boolean',
        'certainty_factor' => 'float',
    ];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function scopeByRisiko($query, $risiko)
    {
        return $query->where('hasil_risiko', $risiko);
    }
}
