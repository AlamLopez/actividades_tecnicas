<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

use App\Exports\InstalacionExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Cliente;
use App\Tecnico;

class ReporteriaController extends Controller
{
    public function actividadtecnica(Request $request)
    {

        $clientes_id = array();
        $tecnicos_id = array();
        $fecha = substr($request->fecha, 0, 10);

        if(!empty($request->clientes)){
            foreach($request->clientes as $item){
                $clientes_id[] = $item['id'];
            }
        }else{
            $clientes = Cliente::all();
            //dd($clientes[1]->id);
            foreach($clientes as $item){
                $clientes_id[] = $item->id;
            }
            //dd($clientes_id);
        }

        if(!empty($request->tecnicos)){
            foreach($request->tecnicos as $item){
                $tecnicos_id[] = $item['id'];
            }
        }else{
            $tecnicos = Tecnico::all();
            foreach($tecnicos as $item){
                $tecnicos_id[] = $item->id;
            }
        }

        if($request->actividad_id == 1){
            
            Excel::store(new InstalacionExport($clientes_id, $tecnicos_id, $fecha), 'instalacion.xlsx', 'instalacion_nueva');
            //return (new InstalacionExport($clientes_id, $tecnicos_id, $fecha))->download('instalacion.csv', \Maatwebsite\Excel\Excel::CSV);
            
            /*
            $file = storage_path() . '\app\actividades_tecnicas\instalacion_nueva\instalacion.xlsx';
            
            $headers = [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ];
    
            return response()->download($file, 'instalacion.xlsx', $headers);
            */
        }

    }
}
