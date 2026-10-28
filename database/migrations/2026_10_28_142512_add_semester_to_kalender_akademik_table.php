<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kalender_akademik', function (Blueprint $table) {
            // Tambah kolom semester setelah tahun_ajaran
            $table->enum('semester', ['Ganjil', 'Genap'])->after('tahun_ajaran');
        });
    }

    public function down(): void
    {
        Schema::table('kalender_akademik', function (Blueprint $table) {
            $table->dropColumn('semester');
        });
    }
};