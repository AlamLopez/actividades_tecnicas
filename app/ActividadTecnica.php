<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActividadTecnica extends Model
{
    //
    //Nombre de la table
    protected $table = 'actividadestecnicas';

    //Llave primaria
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_tecnico', 'id_cliente', 'ingresado_por', 'nombre', 'revisado', 'fecha'
    ];

    public function tecnico()
    {
        return $this->belongsTo(Tecnico::class, 'id_tecnico');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function ingresado_por()
    {
        return $this->belongsTo(User::class, 'ingresado_por');
    }

    public function revisado_por()
    {
        return $this->belongsTo(User::class, 'revisado_por');
    }

    public function instalacionnueva()
    {
        return $this->hasOne(InstalacionNueva::class, 'id_actividadtecnica');
    }

}
