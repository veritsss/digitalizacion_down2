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
        Schema::table('student_answers', function (Blueprint $table) {
            $table->json('selected_images')->nullable()->after('is_correct'); // Agregar columna JSON para almacenar imágenes seleccionadas
        });
    }

    public function down()
    {
        Schema::table('student_answers', function (Blueprint $table) {
            $table->dropColumn('selected_images');
        });
    }
};
