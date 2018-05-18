<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecorridoPlayaVueltaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recorrido_playa_vuelta', function (Blueprint $table) {
            $table->increments('gid');
            $table->string('full_id');
            $table->string('osm_id');
            $table->string('osm_type');
            $table->string('name');
            $table->string('oneway');
            $table->geometry('geom');
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
        Schema::dropIfExists('recorrido_playa_vuelta');
    }
}
