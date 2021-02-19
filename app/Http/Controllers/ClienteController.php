<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Tecnico;
use App\Departamento;
use App\Cliente;
use App\User;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**
         * Desplegar el listado de clientes registrados en el sistema con paginacion
         * Se pueden hacer busquedas de datos segun el criterio que el usuario elija
         */

        if(!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ''){

            $clientes = Cliente::select('clientes.id', 'clientes.nombre', 'clientes.codigoavl', 'clientes.nit', 
                                        'clientes.direccion', 'clientes.giro', 'clientes.telefono1', 'clientes.telefono2', 'clientes.contactocliente', 
                                        'clientes.estadocliente', 'clientes.sac','users.nombrecompleto as nombreuser',  
                                        'departamentos.nombre as departamento', 'municipios.nombre as municipio')
                                ->leftjoin('users', 'users.id', '=', 'clientes.sac')
                                ->leftjoin('departamentos', 'departamentos.id', '=', 'clientes.iddepartamento')
                                ->leftjoin('municipios', 'municipios.id', '=', 'clientes.idmunicipio')
                                ->orderBy('clientes.id')
                                ->paginate(10); 

        }else{
        
            $clientes = Cliente::select('clientes.id', 'clientes.nombre', 'clientes.codigoavl', 'clientes.nit', 
                                        'clientes.direccion', 'clientes.giro', 'clientes.telefono1', 'clientes.telefono2', 'clientes.contactocliente', 
                                        'clientes.estadocliente', 'clientes.sac','users.nombrecompleto as nombreuser',  
                                        'departamentos.nombre as departamento', 'municipios.nombre as municipio')
                                ->leftjoin('users', 'users.id', '=', 'clientes.sac')
                                ->leftjoin('departamentos', 'departamentos.id', '=', 'clientes.iddepartamento')
                                ->leftjoin('municipios', 'municipios.id', '=', 'clientes.idmunicipio')
                                ->where($criterio, 'like', '%' . $buscar . '%')
                                ->orderBy('clientes.id')
                                ->paginate(10);                 
                                
        }


        return [
            
            'pagination' => [
                'total'         => $clientes->total(),
                'current_page'  => $clientes->currentPage(),
                'per_page'      => $clientes->perPage(),
                'last_page'     => $clientes->lastPage(),
                'from'          => $clientes->firstItem(),
                'to'            => $clientes->lastItem(),
            ],

            'clientes' => $clientes

        ];

    }

    public function selectClientes(Request $request)
    {
        /**
         * Desplegar el listado de clientes registrados en el sistema
         * Se pueden hacer busquedas de datos segun lo escrito por el usuario
         */

        if(!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        
        $clientes = Cliente::where('nombre', 'like', '%' . $filtro . '%')
                            ->orWhere('codigoavl', 'like', '%' . $filtro . '%')
                            ->select('id', 'nombre', 'codigoavl')
                            ->orderBy('nombre', 'asc')
                            ->get();

        foreach($clientes as $item){
            if($item->codigoavl != null) $item->nombre = $item->codigoavl . ' ' . $item->nombre;
        }

        return [
            'clientes' => $clientes
        ];
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function actualizarSidco(Request $request)
    {
        /**
         * Sincroniza los clientes registrados en SIDCO con el sistema
         * Obtener el ultimo registro guardado de un cliente en el sistema nuevo.
         * Se consultan los clientes nuevos registrados en SIDCO.
         * Si hay clientes nuevos se ingresan en el sistema nuevo.
         */

        if(!$request->ajax()) return redirect('/');

        $ultimo_cliente = Cliente::orderBy('id', 'desc')->first();
        
        $clientesSIDCO = DB::connection('sidco')
                            ->table('fac_facturadores')
                            ->where('IDfacturador', '>', $ultimo_cliente->id)
                            ->get();

        if($clientesSIDCO->isEmpty()){

            return "vacio";

        }else{

            foreach($clientesSIDCO as $item){
            
                DB::connection('mysql')
                    ->table('clientes')
                    ->insert([
                        'id' => $item->IDfacturador,
                        'nombre' => $item->Nombre,
                        'codigoavl' => $item->CodigoAVL,
                        'nit' => $item->NIT,
                        'direccion' => $item->Direccion,
                        'giro' => $item->Giro,
                        'contactocliente' => $item->Email,
                        'iddepartamento' => $item->IDDepartamento,
                        'idmunicipio' => $item->IDMunicipio,
                        'estadoCliente' => true,
                        'telefono1' => $item->Telefono1,
                        'telefono2' => $item->Telefono2,
                        'created_at' => \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now()
                    ]);
    
            }
    
            return "lleno";
        }
    
    }

    public function actualizarCodigoAVL(Request $request)
    {
        /**
         * Actualiza el codigo AVL del cliente en el sistema y en SIDCO
         */

        if(!$request->ajax()) return redirect('/');

        $cliente = Cliente::findOrFail($request->id);
        
            $cliente->codigoavl = $request->codigoavl;

        $cliente->save();

        DB::connection('sidco')
            ->table('fac_facturadores')
            ->where('IDfacturador', $request->id)
            ->update(['CodigoAVL' => $request->codigoavl]);
            
    }

    public function actualizarCliente(Request $request)
    {
        /**
         * Actualizar en la BD del sistema el registro seleccionado
         */

        if(!$request->ajax()) return redirect('/');

        if($request->sac == 0){
            $request->sac = null;
        }

        $cliente = Cliente::findOrFail($request->id);
        
            $cliente->contactocliente = $request->contactocliente;
            $cliente->estadocliente = $request->estadocliente;
            $cliente->sac = $request->sac;

        $cliente->save();

        DB::connection('sidco')
            ->table('fac_facturadores')
            ->where('IDfacturador', $request->id)
            ->update(['Email' => $request->contactocliente]);
            
    }

    public function unico($codigoavl, $cliente_id)
    {
        /**
         * Verifica que el codigo avl del cliente ingresado 
         * cuando se esta actualizando un registro de 
         * cliente no exista en la BD del sistema. 
         */

        $cliente = Cliente::where('codigoavl', $codigoavl)->first();

        if($cliente == null){
            return "si";
        }elseif($cliente->id == $cliente_id){
            return "si";
        }else{
            return "no";
        }

    }

}
