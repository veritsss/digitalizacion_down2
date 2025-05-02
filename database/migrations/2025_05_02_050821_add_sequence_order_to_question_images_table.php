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
        Schema::table('question_images', function (Blueprint $table) {
            $table->integer('sequence_order')->nullable(); // Campo para almacenar el orden de la secuencia
        });
    }

    public function down()
    {
        Schema::table('question_images', function (Blueprint $table) {
            $table->dropColumn('sequence_order');
        });
    }
};
