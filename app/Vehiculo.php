<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    //Nombre de la table
    protected $table = 'vehiculos';

    //Llave primaria
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'placa', 'marca', 'modelo', 'chasis', 'tipo', 'anio', 'color', 'condicion'
    ];

}
