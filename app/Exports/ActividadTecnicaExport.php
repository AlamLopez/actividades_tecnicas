<?php

namespace App\Exports;

use App\ActividadTecnica;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ActividadTecnicaExport implements FromView
{

    public function __construct($clientes_id, $tecnicos_id, $fecha, $actividad_id)
    {
        $this->clientes_id = $clientes_id;
        $this->tecnicos_id = $tecnicos_id;
        $this->fecha = $fecha;
        $this->actividad_id = $actividad_id;
    }

    public function view(): View
    {
        dd('hola');
        /*return view('pdf.actividadtecnica.instalacion', [
            'actividadtecnicas' => ActividadTecnica::with('cliente', 'tecnico', 'ingresado_por', 'revisado_por')
            ->orderBy('revisado', 'ASC')
            ->orderBy('fecha', 'DESC')->get()
        ]);*/
    }
}
