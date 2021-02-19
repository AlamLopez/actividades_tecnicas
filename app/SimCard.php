<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SimCard extends Model
{
    //Nombre de la table
    protected $table = 'simcards';

    //Llave primaria
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'imsi', 'ip', 'telefono', 'condicion'
    ];

    public function setImsiAttribute($value) 
    {
        $this->attributes['imsi'] = strtoupper($value);
    }

    public function setIpAttribute($value) 
    {
        $this->attributes['ip'] = strtoupper($value);
    }

    public function setTelefonoAttribute($value) 
    {
        $this->attributes['telefono'] = strtoupper($value);
    }

}
