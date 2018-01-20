<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('team_id')->unsigned()->index();
            $table->string('issue_title');
            $table->string('issue_created_date');
            $table->string('issue_response_date');
            $table->string('issue_response_person');
            $table->string('issue_type');
            $table->string('issue_status');
            $table->string('issue_priority');
            $table->text('issue_description');
            $table->text('issue_recommendation');
            $table->text('issue_resolution');
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
        Schema::drop('issues');
    }
}
