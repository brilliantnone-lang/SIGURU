<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KepalaSekolah extends Model
{
    protected $table = 'kepala_sekolah';
    protected $fillable = ['user_id', 'nip_kepsek'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}