<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'surat_id',
    ] ;

         // Define relationship to User (Dosen)
         public function user()
         {
             return $this->belongsTo(User::class, 'user_id');
         }
     
         // Define relationship to surat
         public function surat()
         {
             return $this->belongsTo(Surat::class, 'surat_id');
         }
}
