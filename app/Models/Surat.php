<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $fillable = [
        "file",
        "judul",
        "tahun_ajaran",
        "prodi_id",
    ] ;
 
     // Define relationship to Prodi
     public function prodi()
     {
         return $this->belongsTo(Prodi::class, 'prodi_id');
     }
}
