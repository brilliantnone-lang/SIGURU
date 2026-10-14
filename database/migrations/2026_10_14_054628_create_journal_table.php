<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('guru')->cascadeOnDelete();
            $table->foreignId('guru_pendamping_id')->nullable()->constrained('guru')->nullOnDelete();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->integer('jam_mulai_ke');
            $table->integer('jam_selesai_ke');
            $table->foreignId('jadwal_id')->nullable()->constrained('jadwal')->nullOnDelete();
            $table->date('tanggal');
            $table->text('pokok_bahasan');
            $table->enum('status_penyelesaian', ['selesai', 'belum_selesai']);
            $table->text('alasan_belum_selesai')->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('status_validasi', ['valid', 'belum_valid', 'menunggu_revisi', 'sudah_revisi'])->default('belum_valid');
            $table->string('foto_kegiatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal');
    }
};