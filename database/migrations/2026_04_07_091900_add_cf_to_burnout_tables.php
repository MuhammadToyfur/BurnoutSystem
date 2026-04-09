<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom CF ke diagnosis_rules
        Schema::table('diagnosis_rules', function (Blueprint $table) {
            $table->decimal('certainty_factor', 3, 2)->default(1.00)->after('bobot')
                ->comment('Nilai keyakinan pakar 0.0 - 1.0');
        });

        // Tambah kolom cf_hasil & penjelasan ke diagnosis_sessions
        Schema::table('diagnosis_sessions', function (Blueprint $table) {
            $table->decimal('cf_hasil', 4, 3)->nullable()->after('rekomendasi')
                ->comment('Certainty Factor hasil akhir 0.0 - 1.0');
            $table->json('penjelasan')->nullable()->after('cf_hasil')
                ->comment('Penjelasan kondisi yang terpenuhi');
        });
    }

    public function down(): void
    {
        Schema::table('diagnosis_rules', function (Blueprint $table) {
            $table->dropColumn('certainty_factor');
        });
        Schema::table('diagnosis_sessions', function (Blueprint $table) {
            $table->dropColumn(['cf_hasil', 'penjelasan']);
        });
    }
};
