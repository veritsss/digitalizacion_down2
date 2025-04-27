<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',       // Ruta de la imagen
        'folder',     // Carpeta de la imagen
        'is_correct', // Indica si la imagen es correcta
    ];
}
