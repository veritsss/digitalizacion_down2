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
            $table->integer('correct_group')->nullable(); // Grupo correcto (1, 2 o 3)
        });

        Schema::table('question_images', function (Blueprint $table) {
            $table->integer('size_group')->nullable(); // Grupo asignado a cada imagen (1, 2 o 3)
        });
    }

    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('correct_group');
        });

        Schema::table('question_images', function (Blueprint $table) {
            $table->dropColumn('size_group');
        });
    }
};
