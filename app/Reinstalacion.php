<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reinstalacion extends Model
{
    //
    //Nombre de la table
    protected $table = 'reinstalaciones';

    //Llave primaria
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_actividadtecnica', 'placa', 'nombre', 'id_dispositivo', 'lugar', 'posicion', 'panico', 'cortemotor', 'otros', 'observacion', 'fotos'
    ];

    public function setPlacaAttribute($value) 
    {
        $this->attributes['placa'] = strtoupper($value);
    }

    public function setNombreAttribute($value) 
    {
        $this->attributes['nombre'] = strtoupper($value);
    }

    public function setIddispositivoAttribute($value) 
    {
        $this->attributes['id_dispositivo'] = strtoupper($value);
    }

    public function setLugarAttribute($value) 
    {
        $this->attributes['lugar'] = strtoupper($value);
    }

    public function setOtrosAttribute($value) 
    {
        $this->attributes['otros'] = strtoupper($value);
    }

    public function setObservacionAttribute($value) 
    {
        $this->attributes['observacion'] = strtoupper($value);
    }

    public function actividad_tecnica()
    {
        return $this->belongsTo(ActividadTecnica::class, 'id_actividadtecnica');
    }
}
