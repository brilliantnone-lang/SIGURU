<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_sekolah', function (Blueprint $table) {
            // Tambahkan kolom is_rutin dan hari_rutin setelah is_full_day
            $table->boolean('is_rutin')->default(false)->after('is_full_day');
            $table->enum('hari_rutin', ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'])->nullable()->after('is_rutin');
            
            // Ubah tanggal_mulai jadi nullable karena event rutin tidak butuh tanggal
            $table->date('tanggal_mulai')->nullable()->change();
            $table->date('tanggal_selesai')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('event_sekolah', function (Blueprint $table) {
            $table->dropColumn(['is_rutin', 'hari_rutin']);
        });
    }
};