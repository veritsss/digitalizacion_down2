<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPairIdToQuestionImagesTable extends Migration
{
    public function up()
    {
        Schema::table('question_images', function (Blueprint $table) {
            $table->integer('pair_id')->nullable(); // Identificador del par
        });
    }

    public function down()
    {
        Schema::table('question_images', function (Blueprint $table) {
            $table->dropColumn('pair_id');
        });
    }
}
