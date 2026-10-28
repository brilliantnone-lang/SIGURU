<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KalenderAkademik extends Model
{
    protected $table = 'kalender_akademik';
    
    protected $fillable = [
        'admin_id', 
        'tahun_ajaran', 
        'semester',
        'tanggal_mulai', 
        'tanggal_selesai', 
        'nama_file', 
        'path_file'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    // Fungsi untuk mengambil kalender yang aktif hari ini
    public static function getKalenderAktif()
    {
        $hariIni = \Carbon\Carbon::now()->format('Y-m-d');
        
        return self::where('tanggal_mulai', '<=', $hariIni)
                   ->where('tanggal_selesai', '>=', $hariIni)
                   ->first();
    }
}