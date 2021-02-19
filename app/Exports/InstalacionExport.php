<?php

namespace App\Exports;

use App\InstalacionNueva;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InstalacionExport implements FromView
{

    public function __construct($clientes_id, $tecnicos_id, $fecha)
    {
        $this->clientes_id = $clientes_id;
        $this->tecnicos_id = $tecnicos_id;
        $this->fecha = $fecha;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        
        return view('pdf.actividadtecnica.instalacion', [ 
            'instalaciones' => InstalacionNueva::select('clientes.nombre', 'actividadestecnicas.fecha', 
            'tecnicos.nombre as nombretecnico', 'tecnicos.apellido', 'instalaciones.placa', 'instalaciones.id_dispositivo',
            'gps.imei', 'gps.serie', 'gps.marca', 'gps.modelo', 'simcards.imsi', 'simcards.ip',
            'simcards.telefono', 'instalaciones.lugar', 'instalaciones.cortemotor', 'instalaciones.panico',
            'instalaciones.posicion', 'instalaciones.otros', 'instalaciones.observacion')
            ->join('gps', 'gps.id', '=', 'instalaciones.id_gps')
            ->join('simcards', 'simcards.id', '=', 'instalaciones.id_simcard')
            ->join('actividadestecnicas', 'actividadestecnicas.id', '=', 'instalaciones.id_actividadtecnica')
            ->join('clientes', 'clientes.id', '=', 'actividadestecnicas.id_cliente')
            ->join('tecnicos', 'tecnicos.id', '=', 'actividadestecnicas.id_tecnico')
            ->whereIn('clientes.id', $this->clientes_id)
            ->whereIn('tecnicos.id', $this->tecnicos_id)
            ->where('fecha', $this->fecha)
            ->get()
        ]);
    }
}
