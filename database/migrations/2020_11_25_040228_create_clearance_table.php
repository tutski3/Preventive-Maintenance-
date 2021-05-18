<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClearanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clearance', function (Blueprint $table) {
            $table->string('control_number', 30)->primary();
            $table->boolean('specs_within_standard_minimum_req');
            $table->boolean('revised_specs');
            $table->boolean('item_cleared_for');
            $table->boolean('item_already_purchased');
            $table->string('replacement');
            $table->string('repair');
            $table->string('others');
            $table->integer('user_id');
            $table->string('approved_by');
            $table->string('approved_position');
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
        Schema::dropIfExists('clearance');
    }
}
