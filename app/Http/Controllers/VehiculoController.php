<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Vehiculo;

class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**
         * Desplegar el listado de vehiculos registrados en el sistema con paginacion
         * Se pueden hacer busquedas de datos segun el criterio que el usuario elija
         */

        if(!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ''){
            
            $vehiculos = Vehiculo::select('placa', 'marca', 'modelo', 'chasis', 'tipo', 'anio', 'color', 'condicion')
                                ->orderBy('id', 'desc') 
                                ->paginate(10);

        }else{
            
            $vehiculos = Vehiculo::select('placa', 'marca', 'modelo', 'chasis', 'tipo', 'anio', 'color', 'condicion')
                                ->where($criterio, 'like', '%' . $buscar . '%')
                                ->orderBy('id', 'desc')
                                ->paginate(10);
            
        }

        return [
            
            'pagination' => [
                'total'         => $vehiculos->total(),
                'current_page'  => $vehiculos->currentPage(),
                'per_page'      => $vehiculos->perPage(),
                'last_page'     => $vehiculos->lastPage(),
                'from'          => $vehiculos->firstItem(),
                'to'            => $vehiculos->lastItem(),
            ],

            'vehiculos' => $vehiculos

        ];

    }
    
    public function selectVehiculo(Request $request)
    {
        /**
         * Desplegar el listado de vehiculos registrados en el sistema
         * Se pueden hacer busquedas de datos segun lo escrito por el usuario
         */

        if(!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        
        $vehiculos = Vehiculo::where('placa', 'like', '%' . $filtro . '%')
                            ->select('id', 'placa')
                            ->orderBy('placa', 'asc')
                            ->get();

        return [
            'vehiculos' => $vehiculos
        ];
        
    }

}
