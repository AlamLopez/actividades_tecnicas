<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

use App\TrasladoGps;
use App\ActividadTecnica;

class TrasladoGpsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * Guardar en la BD del sistema el nuevo registro de cambio de sim
         * Primero guarda las imagenes en la carpeta storage 
         * Luego se guarda en BD los nombres de los archivos
         */

        if(!$request->ajax()) return redirect('/');

        $fotos = $request->fotos;

        if(!empty($fotos)){

            $nombres = array();
            
            $i = 0;

            foreach($fotos as $item){

                $i++;

                $img = $this->getB64Image($item);

                $img_extension = $this->getB64Extension($item);

                $img_name = 'traslado_gps_' . $request->id_actividadtecnica . '_' . date("Y") . date("m") . date("d") . "_" . date("H") . date("i") . date("s") . "_" . $i . "." . $img_extension;

                Storage::disk('traslado_gps')->put($img_name, $img);

                $nombres[] = $img_name;

            }

            $nombres_fotos = implode(',', $nombres);

        }else{

            $nombres_fotos = null;

        }

        $trasladogps = TrasladoGps::create([

            'id_actividadtecnica' => $request->id_actividadtecnica,
            'placa_anterior' => $request->placa_anterior,
            'placa_nueva' => $request->placa_nueva,
            'lugar' => $request->lugar,
            'cortemotor' => $request->cortemotor,
            'panico' => $request->panico,
            'posicion' => $request->posicion,
            'otros' => $request->otros,
            'observacion' => $request->observaciones,
            'fotos' => $nombres_fotos
            
        ]);

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
         * Primero verifica que ya tenga fotos, si tiene, borra las anteriores y guarda las nuevas en la carpeta storage 
         * Luego se actualiza en BD los datos solicitados
         */

        if(!$request->ajax()) return redirect('/');

        //dd($request->all());
        
        $fotos_nuevas = $request->fotosnuevas;

        $fotos_viejas = $request->fotosviejas;

        $fecha = substr($request->fecha, 0, 10);

        $actividadtecnica = ActividadTecnica::findOrFail($request->id_actividadtecnica);

            $actividadtecnica->id_tecnico = $request->id_tecnico;
            $actividadtecnica->id_cliente = $request->id_cliente;
            $actividadtecnica->fecha = $fecha;
            $fecha_ingreso = strtotime($actividadtecnica->created_at);

        $actividadtecnica->save();

        // Cuando cambian las fotos de la actividad tecnica
        if(!empty($fotos_nuevas)){

            $ruta = storage_path() . '/app/actividades_tecnicas/traslado_gps/';

            $nombres = array();
            $i = 0;

            if(!empty($fotos_viejas)){
                foreach($fotos_viejas as $item){
                    unlink($ruta . $item);
                }
            }

            foreach($fotos_nuevas as $item){

                $i++;

                $img = $this->getB64Image($item);

                $img_extension = $this->getB64Extension($item);

                $img_name = 'traslado_gps_' . $request->id_actividadtecnica . '_' . date("Y", $fecha_ingreso) . date("m", $fecha_ingreso) . date("d", $fecha_ingreso) . "_" . date("H", $fecha_ingreso) . date("i", $fecha_ingreso) . date("s", $fecha_ingreso) . "_" . $i . "." . $img_extension;

                Storage::disk('traslado_gps')->put($img_name, $img);

                $nombres[] = $img_name;

            }

            $nombres_fotos = implode(',', $nombres);

        }elseif(!empty($fotos_viejas)){
            $nombres_fotos = implode(',', $fotos_viejas);
        }else{
            $nombres_fotos = null;
        }
        
        $trasladogps = TrasladoGps::findOrFail($request->id_trasladogps);

            $trasladogps->placa_anterior = $request->placa_anterior;
            $trasladogps->placa_nueva = $request->placa_nueva;
            $trasladogps->lugar = $request->lugar;
            $trasladogps->posicion = $request->posicion;
            $trasladogps->panico = $request->panico;
            $trasladogps->cortemotor = $request->cortemotor;
            $trasladogps->otros = $request->otros;
            $trasladogps->observacion = $request->observacion;
            $trasladogps->fotos = $nombres_fotos;

        $trasladogps->save();

    }

    public function mostrar($id_actividadtecnica)
    {
        /** Consulta los datos de la actividad tecnica seleccionada por el usuario */

        $trasladogps = TrasladoGps::with('actividad_tecnica.cliente', 'actividad_tecnica.ingresado_por', 
                                       'actividad_tecnica.revisado_por', 'actividad_tecnica.tecnico')
                                ->where('id_actividadtecnica', $id_actividadtecnica)
                                ->first();

        if($trasladogps->fotos != null){
    
            $trasladogps->fotos = explode(',', $trasladogps->fotos);

        }

        return ['trasladogps' => $trasladogps];
    }

    public function getB64Image($base64_image)
    {  
        /**
         * Obtener el String base-64 de los datos
         * Decodificar ese string y devolver los datos de la imagen 
         * Retornamos el string decodificado
         */

        $image_service_str = substr($base64_image, strpos($base64_image, ",")+1);
        
        $image = base64_decode($image_service_str);   
       
        return $image; 

   }

   public function getB64Extension($base64_image, $full=null)
   {
       /**
         * Obtener mediante una expresión regular la extensión imagen y guardarla
         * en la variable "img_extension" 
         * Dependiendo si se pide la extensión completa o no retornar el arreglo con
         * los datos de la extensión en la posición 0 - 1
         */  
                 
        preg_match("/^data:image\/(.*);base64/i",$base64_image, $img_extension);
 
        return ($full) ?  $img_extension[0] : $img_extension[1];  

    }

    public function getImageB64($filename){
        //Obtener la imagen del disco creado anteriormente de acuerdo al nombre de
        // la imagen solicitada
        $file = Storage::disk('traslado_gps')->get($filename);
        // Retornar una respuesta de tipo 200 con el archivo de la Imagen
        return new Response($file,200);
    }
    
}
