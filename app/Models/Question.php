<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['title','type','mode',];

    public function images()
    {
        return $this->hasMany(QuestionImage::class);
    }
    public function carteles()
    {
        return $this->belongsToMany(\App\Models\Cartel::class, 'cartel_question');
    }
}
