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
        Schema::table('images', function (Blueprint $table) {
            $table->integer('size')->nullable(); // Tamaño predefinido: 1 (pequeño), 2 (mediano), 3 (grande)
        });
    }

    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn('size');
        });
    }
};
