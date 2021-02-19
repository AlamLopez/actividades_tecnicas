<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SimCard;

class SimCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**
         * Desplegar el listado de simcards registrados en el sistema con paginacion
         * Se pueden hacer busquedas de datos segun el criterio que el usuario elija
         */

        if(!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ''){
            
            $simcards = SimCard::select('imsi', 'ip', 'telefono', 'condicion')
                                ->orderBy('id', 'desc') 
                                ->paginate(10);

        }else{
            
            $simcards = SimCard::select('imsi', 'ip', 'telefono', 'condicion')
                                ->where($criterio, 'like', '%' . $buscar . '%')
                                ->orderBy('id', 'desc')
                                ->paginate(10);
            
        }

        return [
            
            'pagination' => [
                'total'         => $simcards->total(),
                'current_page'  => $simcards->currentPage(),
                'per_page'      => $simcards->perPage(),
                'last_page'     => $simcards->lastPage(),
                'from'          => $simcards->firstItem(),
                'to'            => $simcards->lastItem(),
            ],

            'simcards' => $simcards

        ];

    }

    public function selectSim(Request $request)
    {
        /**
         * Desplegar el listado de simcards registrados en el sistema
         * Se pueden hacer busquedas de datos segun lo escrito por el usuario
         */

        if(!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        
        $simcards = SimCard::where('imsi', 'like', '%' . $filtro . '%')
                            ->orWhere('ip', 'like', '%' . $filtro . '%')
                            ->orWhere('telefono', 'like', '%' . $filtro . '%')
                            ->select('id', 'imsi', 'ip', 'telefono')
                            ->orderBy('imsi', 'asc')
                            ->get();

        return [
            'simcards' => $simcards
        ];
        
    }

}
