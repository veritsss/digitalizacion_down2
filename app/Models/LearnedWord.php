<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearnedWord extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'letter', 'word'];

    // Relación con el modelo User
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
