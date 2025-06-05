<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class UpdateUsageTypeForClasificacionColorImages extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Actualizar el usage_type para las imágenes en la carpeta clasificacionColor
        DB::table('images')
            ->where('path', 'like', 'images/clasificacionColor/%')
            ->update(['usage_type' => 'pairs']);

        // Actualizar el usage_type para las imágenes en la carpeta clasificacionCategoria
        DB::table('images')
            ->where('path', 'like', 'images/clasificacionCategoria/%')
            ->update(['usage_type' => 'images,pairs']);

        DB::table('images')
            ->where('path', 'like', 'images/pareoporigualdad/%')
            ->update(['usage_type' => 'pairs']);

        DB::table('images')
            ->where('path', 'like', 'images/seriesTemporales/%')
            ->update(['usage_type' => 'seriesTemporales']);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::table('images')
            ->where('path', 'like', 'images/clasificacionColor/%')
            ->update(['usage_type' => 'images']);
        DB::table('images')
            ->where('path', 'like', 'images/clasificacionCategoria/%')
            ->update(['usage_type' => 'images']);
            DB::table('images')
            ->where('path', 'like', 'images/seriesTemporales/%')
            ->update(['usage_type' => 'seriesTemporales']);
    }
};
