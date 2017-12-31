<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id')->unsigned()->index();
            $table->string('project_number');
            $table->string('project_title');
            $table->string('project_name');
            $table->string('project_type');
            $table->string('project_status');
            $table->integer('project_percent_complete');
            $table->string('project_start_date');
            $table->string('project_end_date');
            $table->integer('project_construction_cost');
            $table->string('project_cx_cost');
            $table->text('project_notes');
            $table->string('thumbnail');
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
        Schema::dropIfExists('projects');
    }
}
