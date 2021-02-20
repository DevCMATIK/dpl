<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('grd_id')->index();
            $table->boolean('state')->default(1)->index();
            $table->float('i1')->nullable()->index();
            $table->float('i2')->nullable()->index();
            $table->float('i3')->nullable()->index();
            $table->float('i4')->nullable()->index();
            $table->float('i5')->nullable()->index();
            $table->float('p1')->nullable()->index();
            $table->float('p2')->nullable()->index();
            $table->float('p3')->nullable()->index();
            $table->float('p4')->nullable()->index();
            $table->float('p5')->nullable()->index();
            $table->float('o1')->nullable()->index();
            $table->float('o2')->nullable()->index();
            $table->float('o3')->nullable()->index();
            $table->float('o4')->nullable()->index();
            $table->float('o5')->nullable()->index();
            $table->float('an1')->nullable()->index();
            $table->float('an2')->nullable()->index();
            $table->float('an3')->nullable()->index();
            $table->float('an4')->nullable()->index();
            $table->float('an5')->nullable()->index();
            $table->dateTime('date')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
