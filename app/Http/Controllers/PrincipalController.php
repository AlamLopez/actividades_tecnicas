<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Tecnico;
use App\User;
use App\ActividadTecnica;
use App\SimCard;
use App\Vehiculo;
use App\Gps;
use App\Cliente;

class PrincipalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**
         * Cuenta los registros en algunas tablas para mostrar al usuario 
         * al momento de entrar al sistema 
         */

        $cantidadClientes = Cliente::count();
        $cantidadTecnicos = Tecnico::count();
        $cantidadGps = Gps::count();
        $cantidadSimCard = Simcard::count();
        $cantidadUsuarios = User::count();
        $cantidadVehiculos = Vehiculo::count();
        $cantidadActiTecnicas = ActividadTecnica::count();
        $cantidadActiTecniPendiente = ActividadTecnica::where('revisado', false)->count();

        return [
            'cantidadClientes' => $cantidadClientes,
            'cantidadTecnicos' => $cantidadTecnicos,
            'cantidadGps' => $cantidadGps,
            'cantidadSimcards' => $cantidadSimCard,
            'cantidadUsuarios' => $cantidadUsuarios,
            'cantidadVehiculos' => $cantidadVehiculos,
            'cantidadActiTecnicas' => $cantidadActiTecnicas,
            'cantidadActiTecniPendiente' => $cantidadActiTecniPendiente
        ];

    }

}
