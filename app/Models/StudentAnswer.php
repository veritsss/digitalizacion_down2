<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    use HasFactory;

    // Definir los campos que pueden ser llenados en masa
    protected $fillable = ['student_id', 'question_id', 'image_id', 'is_correct', 'is_answered', 'selected_images'];

    // Relación con el modelo Question
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // Relación con el modelo Image
    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    // Relación con el modelo User (estudiantes)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
