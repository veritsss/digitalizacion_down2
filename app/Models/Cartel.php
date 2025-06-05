<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartel extends Model
{
    use HasFactory;

    // Permitir asignación masiva para el atributo 'text'
    protected $fillable = ['text'];
    public function tarjetasFoto()
    {
        return $this->hasMany(Image::class);
    }
}
