<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $table = 'journal';

    protected $fillable = [
        'guru_id',
        'guru_pendamping_id',
        'kelas_id',
        'jam_mulai_ke',
        'jam_selesai_ke',
        'jadwal_id',
        'tanggal',
        'pokok_bahasan',
        'status_penyelesaian',
        'alasan_belum_selesai',
        'keterangan',
        'status_validasi',
        'validator_id',
        'validated_at',
        'catatan_validasi',
        'foto_kegiatan',
        'jenis_pengajar',
        'jenis_penggantian',
        'guru_pengganti_id',
        'guru_digantikan_id',
        'metode_absensi',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'validated_at' => 'datetime',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function guruPendamping()
    {
        return $this->belongsTo(Guru::class, 'guru_pendamping_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validator_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function getJumlahJamAttribute(): int
    {
        return $this->jam_selesai_ke - $this->jam_mulai_ke + 1;
    }

    public function coverJurnal()
    {
        return $this->belongsTo(CoverJurnal::class);
    }

    public function guruPengganti()
    {
        return $this->belongsTo(
            \App\Models\Guru::class,
            'guru_pengganti_id'
        );
    }

    public function guruDigantikan()
    {
        return $this->belongsTo(
            \App\Models\Guru::class,
            'guru_digantikan_id'
        );
    }

}
