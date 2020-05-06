<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VisualComposerRowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visualcomposer_row', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('model_class');
            $table->integer('model_id')->length(10)->unsigned();
            $table->string('model_crudfield');
            $table->integer('order');
            $table->string('template_class');
            $table->text('content');
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
        Schema::dropIfExists('visualcomposer_row');
    }
}
