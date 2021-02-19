<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Gps;

class GpsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**
         * Desplegar el listado de gps registrados en el sistema con paginacion
         * Se pueden hacer busquedas de datos segun el criterio que el usuario elija
         */

        if(!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ''){
            
            $gps = Gps::select('modelo', 'serie', 'imei', 'marca', 'observacion', 'condicion', 'tipo')
                        ->orderBy('id', 'desc')
                        ->paginate(10);

        }else{
            
            $gps = Gps::select('modelo', 'serie', 'imei', 'marca', 'observacion', 'condicion', 'tipo')
                        ->where($criterio, 'like', '%' . $buscar . '%')
                        ->orderBy('id', 'desc')
                        ->paginate(10);
            
        }


        return [
            
            'pagination' => [
                'total'         => $gps->total(),
                'current_page'  => $gps->currentPage(),
                'per_page'      => $gps->perPage(),
                'last_page'     => $gps->lastPage(),
                'from'          => $gps->firstItem(),
                'to'            => $gps->lastItem(),
            ],

            'gps' => $gps

        ];

    }

    public function selectGps(Request $request)
    {
        /**
         * Desplegar el listado de gps registrados en el sistema
         * Se pueden hacer busquedas de datos segun lo escrito por el usuario
         */

        if(!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        
        $gps = Gps::where('imei', 'like', '%' . $filtro . '%')
                    ->orWhere('serie', 'like', '%' . $filtro . '%')
                    ->select('id', 'imei', 'serie', 'marca', 'modelo')
                    ->orderBy('imei', 'asc')
                    ->get();

        foreach($gps as $item){
            if($item->serie != null) $item->imei = $item->imei . ', ' . $item->serie;
        }

        return [
            'gps' => $gps
        ];
        
    }

}
