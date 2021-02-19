<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstalacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instalaciones', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->bigInteger('id_actividadtecnica')->unsigned();
            $table->string('placa');
            $table->string('id_dispositivo');
            $table->bigInteger('id_gps')->unsigned();
            $table->bigInteger('id_simcard')->unsigned();
            $table->string('lugar')->nullable();
            $table->boolean('posicion')->default(false);
            $table->boolean('panico')->default(false);
            $table->boolean('cortemotor')->default(false);
            $table->string('otros')->nullable();
            $table->text('observacion')->nullable();
            $table->text('fotos')->nullable();

            $table->foreign('id_actividadtecnica')->references('id')->on('actividadestecnicas');
            $table->foreign('id_gps')->references('id')->on('gps');
            $table->foreign('id_simcard')->references('id')->on('simcards');
            
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
        Schema::dropIfExists('instalaciones');
    }
}
