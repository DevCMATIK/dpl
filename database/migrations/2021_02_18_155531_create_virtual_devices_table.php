<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVirtualDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('virtual_devices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('grd_id')->index();
            $table->string('name');
            $table->string('reportable_db')->index();
            $table->string('reportable_table')->index();
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
        Schema::dropIfExists('virtual_devices');
    }
}
