<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    protected $fillable = ['user_id', 'nip_admin'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kalenderAkademik()
    {
        return $this->hasMany(KalenderAkademik::class);
    }
}