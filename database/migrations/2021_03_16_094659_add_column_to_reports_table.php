<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->float('p6')->nullable()->index()->after('p5');
            $table->float('p7')->nullable()->index()->after('p6');
            $table->float('p8')->nullable()->index()->after('p7');
            $table->float('p9')->nullable()->index()->after('p8');
            $table->float('p10')->nullable()->index()->after('p9');
            $table->float('p11')->nullable()->index()->after('p10');
            $table->float('p12')->nullable()->index()->after('p11');
            $table->float('p13')->nullable()->index()->after('p12');
            $table->float('p14')->nullable()->index()->after('p13');
            $table->float('p15')->nullable()->index()->after('p14');
            $table->float('p16')->nullable()->index()->after('p15');
            $table->float('p17')->nullable()->index()->after('p16');
            $table->float('p18')->nullable()->index()->after('p17');
            $table->float('p19')->nullable()->index()->after('p18');
            $table->float('p20')->nullable()->index()->after('p19');
            $table->float('p21')->nullable()->index()->after('p20');
            $table->float('p22')->nullable()->index()->after('p21');
            $table->float('p23')->nullable()->index()->after('p22');
            $table->float('p24')->nullable()->index()->after('p23');
            $table->float('p25')->nullable()->index()->after('p24');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            //
        });
    }
}
