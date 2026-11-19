<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSekolah extends Model
{
    protected $table = 'event_sekolah';

    protected $fillable = [
        'nama_event',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'jam_mulai_ke',
        'jam_selesai_ke',
        'is_full_day',
        'is_rutin',
        'hari_rutin',
        'is_all_guru',     // <-- Tambah: semua guru terlibat
        'admin_id',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
        'is_full_day'     => 'boolean',
        'is_rutin'        => 'boolean',   // <-- Tambah cast
        'is_all_guru'     => 'boolean',   // <-- Tambah cast
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    // Relasi many-to-many ke Guru
    public function gurus()
    {
        return $this->belongsToMany(
            Guru::class,
            'event_sekolah_guru',
            'event_sekolah_id',
            'guru_id'
        )->withTimestamps();
    }

    /**
     * Guru terlibat: semua guru jika is_all_guru, atau guru terpilih.
     */
    public function getGuruTerlibatAttribute()
    {
        if ($this->is_all_guru) {
            return Guru::with('user')->get()->sortBy('user.name');
        }
        return $this->gurus;
    }
}
