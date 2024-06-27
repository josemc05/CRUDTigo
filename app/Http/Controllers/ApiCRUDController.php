<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Tareas;
use Exception;

class ApiCRUDController extends Controller
{
    protected $request;
    protected $logname;
    public function __construct(Request $request) {
        $this->request = $request;
        $this->logname = 'errores'.date('Ymd').'.log';
    }

    public function cargarDatos(){

        $apiRequest = $this->request->all();

        $start = isset($apiRequest['start']) && !empty($apiRequest['start']) ? $apiRequest['start'] : 0;
        $length = isset($apiRequest['length']) && !empty($apiRequest['length']) ? $apiRequest['length'] : 10;

        try{
            $tareas = Tareas::select('tarea', 'id', 'estatus');

            $total = $tareas->count();

            $tareas = $tareas->skip($start)->take($length)->get();

            $response = [
                "recordsTotal" => intval($total),
                "recordsFiltered" => intval($total),
                "data" => $tareas
            ];

            return response()->json($response);
        }catch(Exception $e){
            $response = [
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            ];

            return response()->json($response);
        }

    }

    public function nuevaTarea(){
        $apiRequest = $this->request->all();

        $tarea = isset($apiRequest['tarea']) && !empty($apiRequest['tarea']) ? $apiRequest['tarea'] : '';

        $this->escribirlog($this->logname, '#################### '.date('H:i:s').' ##############################');
        $this->escribirlog($this->logname, '#################### INICIANDO CREACION DE TAREA ##################');

        if (empty($tarea)){
            $response = [
                "estatus" => false,
                "mensaje" => 'EL CAMPO TAREA NO PUEDE ESTAR VACÍO',
            ];

            return response()->json($response, 400);
        }

        try {
            $response = Tareas::crearTarea($tarea);

            if (!$response['realizado']){

                $this->escribirlog($this->logname, 'Error realizar la creacion de la tarea');
                $this->escribirlog($this->logname, $response['archivo']);
                $this->escribirlog($this->logname, $response['linea']);
                $this->escribirlog($this->logname, $response['mensaje'].PHP_EOL);

                $response = [

                    "estatus" => false,
                    "mensaje" => 'NO SE PUDO GUARDAR LA TAREA',
                ];

                return response()->json($response, 400);
            }

            $response = [
                "estatus" => true,
                "mensaje" => 'GUARDADO CON EXITO',
            ];

            $this->escribirlog($this->logname, '#################### TAREA CREADA EXITOSAMENTE ##################'.PHP_EOL);

            return response()->json($response);

        } catch (Exception $e) {
            $this->escribirlog($this->logname, 'Error realizar la creacion de la tarea');
            $this->escribirlog($this->logname, 'Error archivo: '.$e->getFile());
            $this->escribirlog($this->logname, 'Error linea: '.$e->getLine());
            $this->escribirlog($this->logname, 'Error: '.$e->getMessage().PHP_EOL);

            $response = [
                "estatus" => false,
                "mensaje" => 'OCURRIO UN ERROR AL GUARDAR LA TAREA',
            ];

            return response()->json($response, 400);
        }

    }

    public function eliminarTarea($id){
        $this->escribirlog($this->logname, '#################### '.date('H:i:s').' ##############################');
        $this->escribirlog($this->logname, '#################### INICIANDO ELIMINACION DE TAREA ##################');
        $tareaBorrar = Tareas::find($id);

        if (empty($tareaBorrar)){
            $response = [
                "estatus" => false,
                "mensaje" => 'NO SE ENCUENTRA LA TAREA SELECCIONADA',
            ];

            return response()->json($response, 400);
        }

        try {

            $response = Tareas::eliminarTarea($id);

            if (!$response['realizado']){

                $this->escribirlog($this->logname, 'Error realizar la creacion de la tarea');
                $this->escribirlog($this->logname, $response['archivo']);
                $this->escribirlog($this->logname, $response['linea']);
                $this->escribirlog($this->logname, $response['mensaje'].PHP_EOL);

                $response = [

                    "estatus" => false,
                    "mensaje" => 'NO SE PUDO GUARDAR LA TAREA',
                ];

                return response()->json($response, 400);
            }

            $response = [
                "estatus" => true,
                "mensaje" => 'ELIMINADO CON EXITO',
            ];
            $this->escribirlog($this->logname, '#################### TAREA ELIMINADA EXITOSAMENTE ##################'.PHP_EOL);
            return response()->json($response);

        } catch (Exception $e) {

            $this->escribirlog($this->logname, 'Error realizar la eliminacion de la tarea');
            $this->escribirlog($this->logname, 'Error archivo: '.$e->getFile());
            $this->escribirlog($this->logname, 'Error linea: '.$e->getLine());
            $this->escribirlog($this->logname, 'Error: '.$e->getMessage().PHP_EOL);

            $response = [
                "estatus" => false,
                "mensaje" => 'OCURRIO UN ERROR AL ELIMINAR LA TAREA',
            ];

            return response()->json($response, 400);
        }

    }

    public function completarTarea($id){
        $this->escribirlog($this->logname, '#################### '.date('H:i:s').' ##############################');
        $this->escribirlog($this->logname, '#################### INICIANDO COMPLETAR TAREA ##################');

        $tareaCompletar = Tareas::find($id);

        if (empty($tareaCompletar)){
            $response = [
                "estatus" => false,
                "mensaje" => 'NO SE ENCUENTRA LA TAREA SELECCIONADA',
            ];

            return response()->json($response, 400);
        }

        try {
            $response = Tareas::completarTarea($id);

            if (!$response['realizado']){

                $this->escribirlog($this->logname, 'Error realizar la creacion de la tarea');
                $this->escribirlog($this->logname, $response['archivo']);
                $this->escribirlog($this->logname, $response['linea']);
                $this->escribirlog($this->logname, $response['mensaje'].PHP_EOL);

                $response = [

                    "estatus" => false,
                    "mensaje" => 'NO SE PUDO GUARDAR LA TAREA',
                ];

                return response()->json($response, 400);
            }

            $response = [
                "estatus" => true,
                "mensaje" => 'COMPLETADA CON EXITO',
            ];
            $this->escribirlog($this->logname, '#################### TAREA COMPLETADA EXITOSAMENTE ##################'.PHP_EOL);
            return response()->json($response);

        } catch (Exception $e) {
            $this->escribirlog($this->logname, 'Error realizar completar tarea');
            $this->escribirlog($this->logname, 'Error archivo: '.$e->getFile());
            $this->escribirlog($this->logname, 'Error linea: '.$e->getLine());
            $this->escribirlog($this->logname, 'Error: '.$e->getMessage().PHP_EOL);
            $response = [
                "estatus" => false,
                "mensaje" => 'OCURRIO UN ERROR AL COMPLETAR LA TAREA',
            ];

            return response()->json($response, 400);
        }
    }

    public function modificarTarea($id){
        $this->escribirlog($this->logname, '#################### '.date('H:i:s').' ##############################');
        $this->escribirlog($this->logname, '#################### INICIANDO MODIFICACION DE TAREA ##################');
        $apiRequest = $this->request->all();

        $tarea = isset($apiRequest['tarea']) && !empty($apiRequest['tarea']) ? $apiRequest['tarea'] : '';

        if (empty($tarea)){
            $response = [
                "estatus" => false,
                "mensaje" => 'EL CAMPO TAREA NO PUEDE ESTAR VACÍO',
            ];

            return response()->json($response, 400);
        }

        $tareaModificar = Tareas::find($id);

        if (empty($tareaModificar)){
            $response = [
                "estatus" => false,
                "mensaje" => 'NO SE ENCUENTRA LA TAREA SELECCIONADA',
            ];

            return response()->json($response, 400);
        }

        try {
            $response = Tareas::modificarTarea($id, $tarea);

            if (!$response['realizado']){

                $this->escribirlog($this->logname, 'Error realizar la creacion de la tarea');
                $this->escribirlog($this->logname, $response['archivo']);
                $this->escribirlog($this->logname, $response['linea']);
                $this->escribirlog($this->logname, $response['mensaje'].PHP_EOL);

                $response = [

                    "estatus" => false,
                    "mensaje" => 'NO SE PUDO GUARDAR LA TAREA',
                ];

                return response()->json($response, 400);
            }

            $response = [
                "estatus" => true,
                "mensaje" => 'MODIFICADO CON EXITO',
            ];
            $this->escribirlog($this->logname, '#################### TAREA MODIFICADA EXITOSAMENTE ##################'.PHP_EOL);
            return response()->json($response);

        } catch (Exception $e) {
            $this->escribirlog($this->logname, 'Error realizar la modificacion de la tarea');
            $this->escribirlog($this->logname, 'Error archivo: '.$e->getFile());
            $this->escribirlog($this->logname, 'Error linea: '.$e->getLine());
            $this->escribirlog($this->logname, 'Error: '.$e->getMessage().PHP_EOL);
            $response = [
                "estatus" => false,
                "mensaje" => 'OCURRIO UN ERROR AL MODIFICAR LA TAREA',
            ];

            return response()->json($response, 400);
        }
    }

    public function escribirlog($logname , $mensaje){
        $basePath = public_path().'/log/';
        if ( !is_dir( $basePath ) ) {
                if ( mkdir( $basePath, 0777, true ) ) {
                    @chmod( $basePath, 0777 );
                }
            }
        if ( $logname != NULL && $mensaje != NULL ) {
            $logname = $basePath.$logname;
            $write = @file_put_contents ( $logname, $mensaje . PHP_EOL, FILE_APPEND );
        }
        return true;
    }
}
