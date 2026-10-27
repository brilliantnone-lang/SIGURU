<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cover_jurnal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admin')->cascadeOnDelete();
            $table->string('nama_sekolah');
            $table->string('npsn')->nullable();
            $table->text('alamat')->nullable();
            $table->string('logo')->nullable();
            $table->string('tahun_ajaran');
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->string('nama_kepsek');
            $table->string('nip_kepsek');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cover_jurnal');
    }
};