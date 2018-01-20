<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestiontemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questiontemplates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id')->unsigned()->index();
            $table->integer('checklist_id')->unsigned()->index();
            $table->string('question_text');
            $table->string('question_order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questiontemplates');
    }
}
