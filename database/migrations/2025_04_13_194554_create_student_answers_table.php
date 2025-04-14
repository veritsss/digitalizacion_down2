<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentAnswersTable extends Migration
{
    public function up()
    {
        Schema::create('student_answers', function (Blueprint $table) {
            $table->id(); // ID de la respuesta
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade'); // Relación con el estudiante
            $table->foreignId('question_id')->constrained()->onDelete('cascade'); // Relación con la pregunta
            $table->foreignId('image_id')->constrained()->onDelete('cascade'); // Imagen seleccionada por el estudiante
            $table->boolean('is_correct')->default(false); // Indica si la respuesta fue correcta
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_answers');
    }
}
