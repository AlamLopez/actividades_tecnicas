<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    //
    //Nombre de la table
    protected $table = 'clientes';

    //Llave primaria
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'codigoavl', 'nit', 'direccion', 'giro', 'iddepartamento', 'idmunicipio', 'telefono1', 'telefono2', 'contactocliente', 'estadocliente', 'sac'
    ];

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'idmunicipio');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'iddepartamento');
    }

    public function sac()
    {
        return $this->belongsTo(User::class, 'sac');
    }
    
}
