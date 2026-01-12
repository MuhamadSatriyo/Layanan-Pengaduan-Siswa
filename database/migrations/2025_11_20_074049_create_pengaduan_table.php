<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id('id_pengaduan');
            $table->unsignedBigInteger('id_user'); // ubah dari id_siswa menjadi id_user
            $table->unsignedBigInteger('id_kategori');
            $table->string('judul');
            $table->text('isi_pengaduan');
            $table->enum('status', ['baru', 'proses', 'selesai'])->default('baru');
            $table->timestamps();
        
            // foreign key mengacu ke tabel users
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};
