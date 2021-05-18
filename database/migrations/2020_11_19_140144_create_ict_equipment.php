<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIctEquipment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ict_equipment', function (Blueprint $table) {
            $table->id();
            $table->string('user');
            $table->string('center');
            $table->string('unit');
            $table->string('device_id');
            $table->date('issuance_date');
            $table->year('purchase_year');
            $table->string('remarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ict_equipment');
    }
}
