<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\ActividadTecnica;
use App\CambioSim;
use App\Tecnico;
use App\Cliente;
use App\User;
use App\InstalacionNueva;
use App\Homologacion;
use App\Reinstalacion;
use App\Desinstalacion;
use App\CambioGps;
use App\Revision;

use Auth;

class ActividadTecnicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**
         * Desplegar el listado de actividades tecnicas registrados en el sistema con paginacion
         * Se pueden hacer busquedas de datos segun el criterio que el usuario elija
         * Los datos se mostraran de diferente manera dependiendo del tipo de usuario
         */

        if(!$request->ajax()) return redirect('/');

        $user = Auth::user();

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ''){
            $actividades = ActividadTecnica::with('cliente', 'tecnico', 'ingresado_por', 'revisado_por')
                                            ->orderBy('revisado', 'ASC')
                                            ->orderBy('fecha', 'DESC')
                                            ->paginate(10);
        }else{

            $buscarId = array();

            // Cuando el criterio de busqueda es el nombre de un tecnico
            if($criterio == 'id_tecnico'){
                $tecnico = Tecnico::where('nombre', 'like', '%' . $buscar . '%')->first();
                $buscar = $tecnico->id;
            }

            // Cuando el criterio de busqueda es el nombre de un cliente
            if($criterio == 'id_cliente'){
                $cliente = Cliente::where('codigoavl', 'like', '%' . $buscar . '%')->first();
                $buscar = $cliente->id;
            }

            // Cuando el criterio de busqueda es el nombre del usuario que ingreso la actividad
            if($criterio == 'ingresado_por'){
                $user = User::where('nombrecompleto', 'like', '%' . $buscar . '%')->first();
                $buscar = $user->id;
            }

            // Cuando el criterio de busqueda es el nombre del usuario que reviso la actividad
            if($criterio == 'revisado_por'){
                $user = User::where('nombrecompleto', 'like', '%' . $buscar . '%')->first();
                $buscar = $user->id;
            }

            // Cuando el criterio de busqueda es el id del dispositivo gps 
            if($criterio == 'id'){
                
                $instalacion = InstalacionNueva::where('id_dispositivo', $buscar)->get();
                $desinstalacion = Desinstalacion::where('id_dispositivo', $buscar)->get();
                $cambiogps = CambioGps::where('id_dispositivo_viejo', $buscar)->orWhere('id_dispositivo_nuevo', $buscar)->get();
                $homologacion = Homologacion::where('id_dispositivo', $buscar)->get();
                $reinstalacion = Reinstalacion::where('id_dispositivo', $buscar)->get();

                if(isset($instalacion)){
                    foreach($instalacion as $item){
                        $buscarId[] = $item->id_actividadtecnica;
                    }
                }

                if(isset($desinstalacion)){
                    foreach($desinstalacion as $item){
                        $buscarId[] = $item->id_actividadtecnica;
                    }
                }

                if(isset($cambiogps)){
                    foreach($cambiogps as $item){
                        $buscarId[] = $item->id_actividadtecnica;
                    }
                }
                
            }

            $actividades = ActividadTecnica::with('cliente', 'tecnico', 'ingresado_por', 'revisado_por')
                                            ->where($criterio, 'like', '%' . $buscar . '%')
                                            ->orWhereIn('id', $buscarId)
                                            ->orderBy('revisado', 'ASC')
                                            ->orderBy('fecha', 'DESC')
                                            ->paginate(10);

        }

        return [
            
            'pagination' => [
                'total'         => $actividades->total(),
                'current_page'  => $actividades->currentPage(),
                'per_page'      => $actividades->perPage(),
                'last_page'     => $actividades->lastPage(),
                'from'          => $actividades->firstItem(),
                'to'            => $actividades->lastItem(),
            ],

            'actividades' => $actividades,

            'user' => $user

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
         * Guardar en la BD del sistema el nuevo registro de actividad
         * tecnica retorna el objeto actividad que se ingresa en la BD
         */

        if(!$request->ajax()) return redirect('/');

        $request->fecha = substr($request->fecha, 0, 10);

        $actividad = ActividadTecnica::create([

            'nombre' => $request->nombre,
            'id_tecnico' => $request->id_tecnico,
            'id_cliente' => $request->id_cliente,
            'ingresado_por' => $request->ingresado_por,
            'revisado' => $request->revisado,
            'fecha' => $request->fecha
            
        ]);

        return [ 'actividad' => $actividad ];
        
    }

    public function confirmar(Request $request)
    {
        /**
         * El usuario operativa confirma que la actividad tecnica fue revisada
         * y se guarda la fecha y hora de revision y el usuario que revisa.
         */

        if(!$request->ajax()) return redirect('/');

        $user = Auth::user();

        $date = date('Y-m-d H:i:s');

        $actividad = ActividadTecnica::findOrFail($request->id);

            $actividad->revisado = true;
            $actividad->revisado_por = $user->id;
            $actividad->fecha_revision = $date;
        
        $actividad->save();

    }

    public function desconfirmar(Request $request)
    {
        /**
         * El usuario operativa confirma que la actividad tecnica fue 'desrevisada'
         * y se borra la fecha de revision y nombre de quien recibio.
         */

        if(!$request->ajax()) return redirect('/');

        $actividad = ActividadTecnica::findOrFail($request->id);

            $actividad->revisado = false;
            $actividad->revisado_por = null;
            $actividad->fecha_revision = null;
        
        $actividad->save();

    }
    
}
