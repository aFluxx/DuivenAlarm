<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLosDataKbdbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('los_data_kbdb', function (Blueprint $table) {
            $table->id();
            $table->string('losplaats');
            $table->unsignedBigInteger('flight_id');
            $table->string('opmerking')->nullable();
            $table->string('losuur')->nullable();
            $table->string('weer')->nullable();
            $table->timestamps();

            $table->foreign('flight_id')->references('id')->on('flights');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('los_data');
    }
}
