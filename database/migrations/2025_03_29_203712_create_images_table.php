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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('path'); // Ruta de la imagen
            $table->string('folder')->nullable(); // Carpeta de la imagen
            $table->integer('size')->nullable(); // Tamaño predefinido: 1 (pequeño), 2 (mediano), 3 (grande)
            $table->integer('sequence_group')->nullable();
            $table->integer('sequence_order')->nullable(); // Campo para almacenar el orden de la secuencia
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
};
