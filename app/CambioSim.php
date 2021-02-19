<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CambioSim extends Model
{
    //
    //Nombre de la table
    protected $table = 'cambiossims';

    //Llave primaria
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_actividadtecnica', 'placa', 'nombre',  'id_simcard_viejo', 'id_simcard_nuevo', 'lugar', 'posicion', 'panico', 'cortemotor', 'otros', 'observacion', 'fotos'
    ];

    public function setNombreAttribute($value) 
    {
        $this->attributes['nombre'] = strtoupper($value);
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

    public function simcard_viejo()
    {
        return $this->belongsTo(Simcard::class, 'id_simcard_viejo');
    }

    public function simcard_nuevo()
    {
        return $this->belongsTo(Simcard::class, 'id_simcard_nuevo');
    }
}
