<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('diagnosis_sessions', function (Blueprint $table) {
            $table->dropColumn(['jawaban', 'skor_kelelahan', 'skor_depersonalisasi', 'skor_prestasi', 'kategori_risiko']);
            
            $table->integer('age')->default(18);
            $table->string('gender')->nullable();
            $table->string('course')->nullable();
            $table->string('year')->nullable();
            $table->float('daily_study_hours')->default(0);
            $table->float('daily_sleep_hours')->default(0);
            $table->float('screen_time_hours')->default(0);
            $table->string('stress_level')->nullable();
            $table->integer('anxiety_score')->default(0);
            $table->integer('depression_score')->default(0);
            $table->integer('academic_pressure_score')->default(0);
            $table->integer('financial_stress_score')->default(0);
            $table->integer('social_support_score')->default(0);
            $table->float('physical_activity_hours')->default(0);
            $table->string('sleep_quality')->nullable();
            $table->float('attendance_percentage')->default(0);
            $table->float('cgpa')->default(0);
            $table->string('internet_quality')->nullable();
            $table->string('burnout_level')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diagnosis_sessions', function (Blueprint $table) {
            $table->dropColumn([
                'age', 'gender', 'course', 'year', 'daily_study_hours',
                'daily_sleep_hours', 'screen_time_hours', 'stress_level',
                'anxiety_score', 'depression_score', 'academic_pressure_score',
                'financial_stress_score', 'social_support_score', 'physical_activity_hours',
                'sleep_quality', 'attendance_percentage', 'cgpa', 'internet_quality',
                'burnout_level'
            ]);
            $table->json('jawaban')->nullable();
            $table->integer('skor_kelelahan')->default(0);
            $table->integer('skor_depersonalisasi')->default(0);
            $table->integer('skor_prestasi')->default(0);
            $table->enum('kategori_risiko', ['Rendah', 'Sedang', 'Tinggi'])->nullable();
        });
    }
};
