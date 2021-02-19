<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gps extends Model
{
    //Nombre de la table
    protected $table = 'gps';

    //Llave primaria
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'modelo', 'serie', 'imei', 'marca', 'observacion', 'condicion', 'tipo'
    ];

}
