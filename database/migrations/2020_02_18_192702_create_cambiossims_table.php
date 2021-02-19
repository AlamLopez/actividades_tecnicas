<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCambiossimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cambiossims', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->bigInteger('id_actividadtecnica')->unsigned();
            $table->string('nombre');
            $table->string('placa');
            $table->bigInteger('id_simcard_viejo')->unsigned();
            $table->bigInteger('id_simcard_nuevo')->unsigned();
            $table->string('lugar');
            $table->boolean('posicion')->default(false);
            $table->boolean('panico')->default(false);
            $table->boolean('cortemotor')->default(false);
            $table->string('otros')->nullable();
            $table->text('observacion')->nullable();
            $table->text('fotos')->nullable();

            $table->foreign('id_actividadtecnica')->references('id')->on('actividadestecnicas');
            $table->foreign('id_simcard_viejo')->references('id')->on('simcards');
            $table->foreign('id_simcard_nuevo')->references('id')->on('simcards');

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
        Schema::dropIfExists('cambiossims');
    }
}
