<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id')->unsigned()->index();
            $table->integer('asset_id')->unsigned()->index();
            $table->string('checklist_title');
            $table->string('checklist_tag');
            $table->string('checklist_contractor');
            $table->string('checklist_status');
            $table->string('checklist_type');
            $table->integer('checklist_category_order');
            $table->text('checklist_notes');
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
        Schema::dropIfExists('checklists');
    }
}
