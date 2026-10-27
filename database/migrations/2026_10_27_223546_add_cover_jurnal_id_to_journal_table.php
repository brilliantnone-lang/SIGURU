<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('journal', function (Blueprint $table) {
            $table->foreignId('cover_jurnal_id')->nullable()
                ->constrained('cover_jurnal')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('journal', function (Blueprint $table) {
            $table->dropForeign(['cover_jurnal_id']);
            $table->dropColumn('cover_jurnal_id');
        });
    }
};
