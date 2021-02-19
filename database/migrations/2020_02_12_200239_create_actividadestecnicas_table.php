<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActividadestecnicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividadestecnicas', function (Blueprint $table) {
            
            $table->bigIncrements('id');

            $table->bigInteger('id_tecnico')->unsigned();
            $table->bigInteger('id_cliente')->unsigned();
            $table->bigInteger('ingresado_por')->unsigned();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->boolean('revisado')->default(false);
            $table->bigInteger('revisado_por')->unsigned()->nullable();
            $table->date('fecha');
            $table->datetime('fecha_revision')->nullable();

            $table->foreign('id_tecnico')->references('id')->on('tecnicos');
            $table->foreign('id_cliente')->references('id')->on('clientes');
            $table->foreign('ingresado_por')->references('id')->on('users');
            $table->foreign('revisado_por')->references('id')->on('users');

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
        Schema::dropIfExists('actividadestecnicas');
    }
}
