<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_options', function (Blueprint $table) {
            $table->increments('option_id');
            $table->integer('attribute_id')->unsigned();
            $table->string('label');
            $table->string('value');
            $table->integer('sort_order')->unsigned()->default(0);
            $table->foreign('attribute_id')
                  ->references('attribute_id')->on('attributes')
                  ->onDelete('cascade');
            $table->unique(['attribute_id', 'value']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('attribute_options');
    }
}
