<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id')->unsigned()->index();
            $table->integer('checklist_id')->unsigned()->index();
            $table->string('question_text');
            $table->string('question_order');
            $table->string('question_status');
            $table->string('answer_design');
            $table->string('answer_submitted');
            $table->string('answer_installed');
            $table->string('answer_accepted');
            $table->string('answer_cxreview');
            $table->string('answer_comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
