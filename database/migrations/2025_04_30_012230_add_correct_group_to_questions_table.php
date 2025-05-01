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
        Schema::table('questions', function (Blueprint $table) {
            $table->integer('correct_group')->nullable(); // Campo para almacenar el grupo correcto (1, 2 o 3)
        });
    }

    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('correct_group'); // Eliminar el campo si se revierte la migración
        });
    }
};
