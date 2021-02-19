<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Tecnico;

class TecnicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**
         * Desplegar el listado de tecnicos registrados en el sistema con paginacion
         * Se pueden hacer busquedas de datos segun el criterio que el usuario elija
         */

        if(!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ''){
            $tecnicos = Tecnico::orderBy('id', 'desc')->paginate(10);
        }else{
            $tecnicos = Tecnico::where($criterio, 'like', '%' . $buscar . '%')->orderBy('id', 'desc')->paginate(10);;
        }


        return [
            
            'pagination' => [
                'total'         => $tecnicos->total(),
                'current_page'  => $tecnicos->currentPage(),
                'per_page'      => $tecnicos->perPage(),
                'last_page'     => $tecnicos->lastPage(),
                'from'          => $tecnicos->firstItem(),
                'to'            => $tecnicos->lastItem(),
            ],

            'tecnicos' => $tecnicos

        ];

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * Guardar en la BD del sistema el nuevo registro de tecnico
         */

        if(!$request->ajax()) return redirect('/');

        $tecnico = new Tecnico();

            $tecnico->nombre = $request->nombre;
            $tecnico->apellido = $request->apellido;

        $tecnico->save();
        
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        /**
         * Actualizar en la BD del sistema el registro seleccionado
         */

        if(!$request->ajax()) return redirect('/');

        $tecnico = Tecnico::findOrFail($request->id);

            $tecnico->nombre = $request->nombre;
            $tecnico->apellido = $request->apellido;

        $tecnico->save();

    }

    public function desactivar(Request $request)
    {
        /**
         * Cambiar el estado de un tecnico a Desactivado
         */

        if(!$request->ajax()) return redirect('/');

        $tecnico = Tecnico::findOrFail($request->id);

            $tecnico->condicion = false;

        $tecnico->save();

    }

    public function activar(Request $request)
    {
        /**
         * Cambiar el estado de un tecnico a Activado
         */

        if(!$request->ajax()) return redirect('/');

        $tecnico = Tecnico::findOrFail($request->id);

            $tecnico->condicion = true;

        $tecnico->save();

    }

    public function selectTecnicos(Request $request)
    {
        /**
         * Desplegar el listado de clientes registrados en el sistema
         * Se pueden hacer busquedas de datos segun lo escrito por el usuario
         */

        if(!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        
        $tecnicos = Tecnico::where('nombre', 'like', '%' . $filtro . '%')
                            ->orWhere('apellido', 'like', '%' . $filtro . '%')
                            ->select('id', 'nombre', 'apellido')
                            ->orderBy('nombre', 'asc')
                            ->get();

        foreach($tecnicos as $item){
            $item->nombre = $item->nombre . ' ' . $item->apellido;
        }

        return [
            'tecnicos' => $tecnicos
        ];
        
    }

    
}
