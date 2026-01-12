<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pengaduan;

class Kategori extends Model
{
    use HasFactory;

    // =========================
    // KONFIGURASI TABEL
    // =========================
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';

    // =========================
    // KOLOM YANG BOLEH DIISI
    // =========================
    protected $fillable = [
        'nama_kategori',
    ];

    // =========================
    // DATA KATEGORI DEFAULT
    // =========================
    public static function defaultKategori()
    {
        return [
            ['nama_kategori' => 'Fasilitas Sekolah'],
            ['nama_kategori' => 'Guru / Staf'],
            ['nama_kategori' => 'Administrasi'],
            ['nama_kategori' => 'Keamanan'],
            ['nama_kategori' => 'Bullying'],
        ];
    }

    // =========================
    // RELASI KE PENGADUAN
    // =========================
    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'id_kategori', 'id_kategori');
    }
}
