<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Pengaduan;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // =========================
    // MASS ASSIGNMENT
    // =========================
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nis',
        'kelas',
    ];

    // =========================
    // ATRIBUT TERSEMBUNYI
    // =========================
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // =========================
    // CASTING ATRIBUT
    // =========================
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Laravel 10+
    ];

    // =========================
    // RELASI PENGADUAN (SISWA)
    // =========================
    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'id_siswa', 'id');
    }
}
