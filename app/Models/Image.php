<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',       // Ruta de la imagen
        'folder',
        'usage_type',
        'associated_text',
        'cartel_id' // Carpeta de la imagen
    ];
 public function cartel()
    {
         return $this->belongsTo(Cartel::class, 'cartel_id');
    }
}
