<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('modul_ajar', function (Blueprint $table) {
            // Tambahkan kelas_id (boleh null jika hanya mapel tertentu)
            $table->foreignId('kelas_id')->nullable()->after('guru_id')->constrained('kelas')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('modul_ajar', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn('kelas_id');
        });
    }
};