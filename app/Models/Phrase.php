<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phrase extends Model
{
    use HasFactory;

    protected $fillable = ['image_id', 'word', 'phrase', 'student_id'];
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }
}
