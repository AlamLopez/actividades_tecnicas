<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gps', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            
            $table->string('modelo')->nullable();
            $table->string('serie')->nullable();
            $table->string('imei')->nullable();
            $table->string('marca')->nullable();
            $table->string('observacion')->nullable();
            $table->boolean('condicion')->nullable();
            $table->string('tipo')->nullable();

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
        Schema::dropIfExists('gps');
    }
}
