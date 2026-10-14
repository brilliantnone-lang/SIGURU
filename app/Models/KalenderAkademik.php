<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KalenderAkademik extends Model
{
    protected $table = 'kalender_akademik';
    protected $fillable = ['admin_id', 'nama_file', 'path_file'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}