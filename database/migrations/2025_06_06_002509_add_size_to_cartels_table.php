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
        Schema::table('cartels', function (Blueprint $table) {
            $table->string('size')->nullable()->after('text'); // o integer, según tu necesidad
        });
    }

    public function down()
    {
        Schema::table('cartels', function (Blueprint $table) {
            $table->dropColumn('size');
        });
    }
};
