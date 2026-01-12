<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Lampiran;
use App\Models\Tanggapan;

class Pengaduan extends Model
{
    use HasFactory;

    // =========================
    // KONFIGURASI TABEL
    // =========================
    protected $table = 'pengaduan';
    protected $primaryKey = 'id_pengaduan';

    // TABEL PAKAI created_at & updated_at
    public $timestamps = true;

    // =========================
    // KOLOM YANG BOLEH DIISI
    // =========================
    protected $fillable = [
        'id_user',
        'id_kategori',
        'judul',
        'isi_pengaduan',
        'status',
    ];

    // =========================
    // RELASI KE USER (SISWA)
    // =========================
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    // =========================
    // RELASI KE KATEGORI
    // =========================
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function lampiran()
    {
        return $this->hasMany(Lampiran::class, 'id_pengaduan', 'id_pengaduan');
    }

    public function tanggapan()
    {
        return $this->hasMany(Tanggapan::class, 'id_pengaduan', 'id_pengaduan');
    }
}