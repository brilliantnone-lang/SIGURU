<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_sekolah', function (Blueprint $table) {
            $table->boolean('is_all_guru')->default(false)->after('is_full_day');
        });

        // Event rutin tidak punya tanggal_mulai, jadi harus nullable
        Schema::table('event_sekolah', function (Blueprint $table) {
            $table->date('tanggal_mulai')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('event_sekolah', function (Blueprint $table) {
            $table->dropColumn(['is_rutin', 'hari_rutin', 'is_all_guru']);
        });

        Schema::table('event_sekolah', function (Blueprint $table) {
            $table->date('tanggal_mulai')->nullable(false)->change();
        });
    }
};