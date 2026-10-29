<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'jenis_kelamin',
        'ttd_kepsek',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Relasi
    public function guru()
    {
        return $this->hasOne(Guru::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function kepalaSekolah()
    {
        return $this->hasOne(KepalaSekolah::class);
    }

    // Helper cek role
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isKepsek(): bool
    {
        return $this->role === 'kepsek';
    }

    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }
}