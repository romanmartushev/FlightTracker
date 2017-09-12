<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->date('date')->default("2017-06-15", "%M %d %Y");
            $table->time('time')->default('00:00:00');
            $table->string('depAirline');
            $table->string('depFlightNo');
            $table->string('retAirline');
            $table->string('retFlightNo');
            $table->float('fare');
            $table->string('comment');
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
        Schema::dropIfExists('flights');
    }
}
