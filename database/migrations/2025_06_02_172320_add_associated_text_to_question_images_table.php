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
        $table->string('associated_text')->nullable(); // Texto asociado a la imagen
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('question_images', function (Blueprint $table) {
            //
        });
    }
};
