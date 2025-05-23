<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionImage extends Model
{
    use HasFactory;

    protected $fillable = ['question_id', 'image_id', 'is_correct', 'is_answered', 'selected_images'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }
}
