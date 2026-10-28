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
        'is_rutin',        // <-- Tambah ini
        'hari_rutin',      // <-- Tambah ini
        'admin_id',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_full_day' => 'boolean',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
