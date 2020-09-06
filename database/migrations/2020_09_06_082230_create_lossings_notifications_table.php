<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLossingsNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lossings_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('to_device')->nullable();
            $table->json('data')->nullable();
            $table->json('body')->nullable();
            $table->string('losplaats')->nullable();
            $table->string('losuur')->nullable();
            $table->string('opmerking')->nullable();
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
        Schema::dropIfExists('lossings_notifications');
    }
}
