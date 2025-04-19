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
        $table->boolean('is_answered')->default(false)->after('pair_id');
    });
}

public function down()
{
    Schema::table('question_images', function (Blueprint $table) {
        $table->dropColumn('is_answered');
    });
}
};
