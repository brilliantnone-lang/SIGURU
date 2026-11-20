<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('journal', function (Blueprint $table) {
            $table->enum('status_penggantian', [
                'tidak_ada',
                'menunggu_diisi',
                'selesai_diisi',
            ])->default('tidak_ada')->after('jenis_penggantian');
        });
    }

    public function down(): void
    {
        Schema::table('journal', function (Blueprint $table) {
            $table->dropColumn('status_penggantian');
        });
    }
};