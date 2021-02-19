<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrasladosgpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trasladosgps', function (Blueprint $table) {
            
            $table->bigIncrements('id');

            $table->bigInteger('id_actividadtecnica')->unsigned();
            $table->string('placa_anterior');
            $table->string('placa_nueva');
            $table->string('lugar');
            $table->boolean('posicion')->default(false);
            $table->boolean('panico')->default(false);
            $table->boolean('cortemotor')->default(false);
            $table->string('otros')->nullable();
            $table->text('observacion')->nullable();
            $table->text('fotos')->nullable();

            $table->foreign('id_actividadtecnica')->references('id')->on('actividadestecnicas');

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
        Schema::dropIfExists('trasladosgps');
    }
}
