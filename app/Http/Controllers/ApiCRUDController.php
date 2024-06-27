<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Tareas;
use Exception;

class ApiCRUDController extends Controller
{
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
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

        if (empty($tarea)){
            $response = [
                "estatus" => false,
                "mensaje" => 'EL CAMPO TAREA NO PUEDE ESTAR VACÍO',
            ];

            return response()->json($response, 400);
        }

        try {
            $response = Tareas::crearTarea($tarea);

            if (!$response){
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

            return response()->json($response);

        } catch (Exception $e) {
            $response = [
                "estatus" => false,
                "mensaje" => 'OCURRIO UN ERROR AL GUARDAR LA TAREA',
            ];

            return response()->json($response, 400);
        }

    }

    public function eliminarTarea($id){

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

            if (!$response){
                $response = [
                    "estatus" => false,
                    "mensaje" => 'NO SE PUDO ELIMINAR LA TAREA',
                ];

                return response()->json($response, 400);
            }

            $response = [
                "estatus" => true,
                "mensaje" => 'ELIMINADO CON EXITO',
            ];

            return response()->json($response);

        } catch (Exception $e) {
            $response = [
                "estatus" => false,
                "mensaje" => 'OCURRIO UN ERROR AL ELIMINAR LA TAREA',
            ];

            return response()->json($response, 400);
        }

    }

    public function completarTarea($id){
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

            if (!$response){
                $response = [
                    "estatus" => false,
                    "mensaje" => 'NO SE PUDO COMPLETAR LA TAREA',
                ];

                return response()->json($response, 400);
            }

            $response = [
                "estatus" => true,
                "mensaje" => 'COMPLETADA CON EXITO',
            ];

            return response()->json($response);

        } catch (Exception $e) {
            $response = [
                "estatus" => false,
                "mensaje" => 'OCURRIO UN ERROR AL COMPLETAR LA TAREA',
            ];

            return response()->json($response, 400);
        }
    }

    public function modificarTarea($id){
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

            if (!$response){
                $response = [
                    "estatus" => false,
                    "mensaje" => 'NO SE PUDO MODIFICAR LA TAREA',
                ];

                return response()->json($response, 400);
            }

            $response = [
                "estatus" => true,
                "mensaje" => 'MODIFICADO CON EXITO',
            ];

            return response()->json($response);

        } catch (Exception $e) {
            $response = [
                "estatus" => false,
                "mensaje" => 'OCURRIO UN ERROR AL MODIFICAR LA TAREA',
            ];

            return response()->json($response, 400);
        }
    }
}
