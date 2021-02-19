<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CambioGps extends Model
{
    //
    //Nombre de la table
    protected $table = 'cambiosgps';

    //Llave primaria
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_actividadtecnica', 'placa', 'nombre', 'id_dispositivo_viejo', 'id_gps_viejo', 'id_dispositivo_nuevo', 'id_gps_nuevo', 'id_simcard_nuevo', 'lugar', 'posicion', 'panico', 'cortemotor', 'otros', 'observacion', 'fotos'
    ];

    public function setNombreAttribute($value) 
    {
        $this->attributes['nombre'] = strtoupper($value);
    }

    public function setIddispositivoviejoAttribute($value) 
    {
        $this->attributes['id_dispositivo_viejo'] = strtoupper($value);
    }

    public function setIddispositivonuevoAttribute($value) 
    {
        $this->attributes['id_dispositivo_nuevo'] = strtoupper($value);
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

    public function gps_viejo()
    {
        return $this->belongsTo(Gps::class, 'id_gps_viejo');
    }

    public function gps_nuevo()
    {
        return $this->belongsTo(Gps::class, 'id_gps_nuevo');
    }

    public function simcard_nuevo()
    {
        return $this->belongsTo(Simcard::class, 'id_simcard_nuevo');
    }

    
    
}
