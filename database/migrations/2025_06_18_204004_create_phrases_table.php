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
    Schema::create('phrases', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('image_id');
        $table->string('word');
        $table->string('phrase');
        $table->unsignedBigInteger('student_id'); // Relación con el estudiante
        $table->timestamps();
        $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');
        $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phrases');
    }
};
