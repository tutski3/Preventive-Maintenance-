<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicePc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_pc', function (Blueprint $table) {
            $table->id();
            $table->string('device_id');
            $table->string('property_number');
            $table->string('type');
            $table->string('procie');
            $table->string('gpu');
            $table->string('ram');
            $table->string('storage');
            $table->string('os');
            $table->string('office');
            $table->string('ip_lan');
            $table->string('ip_wlan');
            $table->string('mac_lan');
            $table->string('mac_wlan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_pc');
    }
}
