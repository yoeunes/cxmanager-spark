<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasktemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasttemplates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id')->unsigned()->index();
            $table->string('task');
            $table->string('shortname');
            $table->string('duration');
            $table->string('start');
            $table->string('finish');
            $table->string('cost');
            $table->string('actual_duration');
            $table->string('actual_start');
            $table->string('actual_finish');
            $table->string('remaining_duration');
            $table->string('remaining_cost');
            $table->string('rate');
            $table->string('percent_complete');
            $table->string('percent_remaining');
            $table->text('notes');
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
        Schema::dropIfExists('tasktemplates');
    }
}
