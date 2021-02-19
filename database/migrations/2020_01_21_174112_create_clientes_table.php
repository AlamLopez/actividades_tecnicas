<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {

            $table->bigIncrements('id');
            
            $table->string('nombre')->nullable();
            $table->string('codigoavl')->nullable();
            $table->string('nit')->nullable();
            $table->string('direccion')->nullable();
            $table->string('giro')->nullable();
            $table->bigInteger('iddepartamento')->unsigned()->nullable();
            $table->bigInteger('idmunicipio')->unsigned()->nullable();
            $table->string('telefono1')->nullable();
            $table->string('telefono2')->nullable();
            $table->string('contactocliente')->nullable();
            $table->boolean('estadocliente');
            $table->bigInteger('sac')->unsigned()->nullable();

            $table->foreign('iddepartamento')->references('id')->on('departamentos');
            $table->foreign('idmunicipio')->references('id')->on('municipios');
            $table->foreign('sac')->references('id')->on('users');

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
        Schema::dropIfExists('clientes');
    }
}
