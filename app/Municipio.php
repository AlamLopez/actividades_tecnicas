<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    //
    //Nombre de la table
    protected $table = 'municipios';

    //Llave primaria
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'iddepartamento'
    ];

    public function departamento()
    {
        return $this->belongTo(Departamento::class, 'iddepartamento');
    }

    public function cliente()
    {
        return $this->hasOne(Cliente::class);
    }
}
