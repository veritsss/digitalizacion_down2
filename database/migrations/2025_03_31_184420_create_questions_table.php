<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('questions', function (Blueprint $table) {
        $table->id();
        $table->string('title'); // Título o descripción de la pregunta
        $table->string('type')->default('pareo'); // Tipo de actividad (pareo, asociacion, etc.)
        $table->string('mode')->nullable(); // Agrega el campo 'mode' después del campo 'type'
        $table->timestamps();
    });

    Schema::create('question_images', function (Blueprint $table) {
        $table->id();
        $table->foreignId('question_id')->constrained()->onDelete('cascade');
        $table->foreignId('image_id')->constrained()->onDelete('cascade');
        $table->boolean('is_correct')->default(false); // Indica si la imagen es correcta
        $table->boolean('is_answered')->default(false); // Indica si la pregunta fue respondida
        $table->json('selected_images')->nullable(); // Agregar columna JSON para almacenar imágenes seleccionadas
        $table->integer('pair_id')->nullable(); // Identificador del par



        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
