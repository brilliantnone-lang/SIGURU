<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah enum untuk tambah 'belum_direvisi'
        DB::statement("ALTER TABLE journal MODIFY COLUMN status_penggantian ENUM('tidak_ada', 'menunggu_diisi', 'belum_direvisi', 'selesai_diisi') NOT NULL DEFAULT 'tidak_ada'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE journal MODIFY COLUMN status_penggantian ENUM('tidak_ada', 'menunggu_diisi', 'selesai_diisi') NOT NULL DEFAULT 'tidak_ada'");
    }
};