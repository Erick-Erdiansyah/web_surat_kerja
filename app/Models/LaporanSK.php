<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanSK extends Model
{
    use HasFactory;
      protected $fillable = [
        'jurusan_id',   
        'kategori_id',
        'sub_kategori_id',
        'nomor_surat',
        'tanggal_surat',
        'judul',
        'deskripsi',
        'tahun_ajaran',
        'file',
    ];

    public function jurusan() {
        return $this->belongsTo(Jurusan::class);
    }

    public function kategori() {
        return $this->belongsTo(Kategori::class);
    }

    public function sub_kategori() {
        return $this->belongsTo(SubKategori::class);
    }
}
