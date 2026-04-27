<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiagnosisSession extends Model
{
    protected $fillable = [
        'user_id', 'total_skor', 'rule_terpilih', 'rekomendasi', 'cf_hasil', 'penjelasan',
        'age', 'gender', 'course', 'year', 'daily_study_hours', 'daily_sleep_hours',
        'screen_time_hours', 'stress_level', 'anxiety_score', 'depression_score',
        'academic_pressure_score', 'financial_stress_score', 'social_support_score',
        'physical_activity_hours', 'sleep_quality', 'attendance_percentage', 'cgpa',
        'internet_quality', 'burnout_level'
    ];

    protected $casts = [
        'penjelasan' => 'array',
        'cf_hasil' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBadgeColorAttribute(): string
    {
        return match($this->burnout_level) {
            'Low' => 'success',
            'Medium' => 'warning',
            'High' => 'danger',
            'Rendah' => 'success',
            'Sedang' => 'warning',
            'Tinggi' => 'danger',
            default => 'secondary',
        };
    }

    public function getProgressColorAttribute(): string
    {
        return match($this->burnout_level) {
            'Low', 'Rendah' => '#22c55e',
            'Medium', 'Sedang' => '#f59e0b',
            'High', 'Tinggi' => '#ef4444',
            default => '#6b7280',
        };
    }
}
