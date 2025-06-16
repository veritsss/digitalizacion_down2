<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearnedWordsTable extends Migration
{
    public function up()
    {
        Schema::create('learned_words', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id'); // Relación con el estudiante
            $table->string('letter', 1); // Letra del abecedario
            $table->string('word'); // Palabra aprendida
            $table->timestamps();

            // Clave foránea
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('learned_words');
    }
}
