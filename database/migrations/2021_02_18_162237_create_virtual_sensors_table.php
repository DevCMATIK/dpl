<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVirtualSensorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('virtual_sensors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('device_id')->unsigned()->index();
            $table->string('address')->index();
            $table->string('name')->index();
            $table->string('reportable_field')->index();
            $table->string('reportable_value')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('virtual_sensors');
    }
}
