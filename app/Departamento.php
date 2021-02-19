<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    //
    //Nombre de la table
    protected $table = 'departamentos';

    //Llave primaria
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre'
    ];

    public function municipios()
    {
        return $this->hasMany(Municipio::class);
    }

    public function cliente()
    {
        return $this->hasOne(Cliente::class);
    }
}
