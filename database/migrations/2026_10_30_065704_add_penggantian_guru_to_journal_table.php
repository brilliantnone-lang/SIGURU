<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('journal', function (Blueprint $table) {
            $table->enum('jenis_pengajar', [
                'pengampu',
                'pengganti',
            ])->default('pengampu');

            $table->enum('jenis_penggantian', [
                'saya_digantikan',
                'saya_menggantikan',
            ])->nullable();

            $table->foreignId('guru_pengganti_id')
                ->nullable()
                ->constrained('guru')
                ->nullOnDelete();

            $table->foreignId('guru_digantikan_id')
                ->nullable()
                ->constrained('guru')
                ->nullOnDelete();

            $table->enum('metode_absensi', [
                'otomatis',
                'manual',
            ])->default('otomatis');
        });
    }

    public function down(): void
    {
        Schema::table('journal', function (Blueprint $table) {
            $table->dropForeign(['guru_pengganti_id']);
            $table->dropForeign(['guru_digantikan_id']);

            $table->dropColumn([
                'jenis_pengajar',
                'jenis_penggantian',
                'guru_pengganti_id',
                'guru_digantikan_id',
                'metode_absensi',
            ]);
        });
    }
};