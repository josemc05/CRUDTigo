<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Exception;

class Tareas extends Model
{
    use HasFactory;

    protected $table = 'tareas';


    public static function crearTarea($tarea)
    {
        try{
            $response = DB::statement('CALL CrearTarea(?)', [$tarea]);

            $response = [
                'realizado'=> $response,
                'archivo'=> '',
                'linea'=> '',
                'mensaje'=> 'No se pudo ejecutar el procedimiento',
            ];

            return $response;
        }catch(Exception $e){
            $response = [
                'realizado'=>false,
                'archivo'=> 'Error archivo: '.$e->getFile(),
                'linea'=> 'Error linea: '.$e->getLine(),
                'mensaje'=> 'Error: '.$e->getMessage(),
            ];
            return $response;
        }


    }

    public static function modificarTarea($id, $tarea)
    {
        try{
        $response = DB::statement('CALL ModificarTarea(?, ?)', [$id, $tarea]);

        $response = [
            'realizado'=> $response,
            'archivo'=> '',
            'linea'=> '',
            'mensaje'=> 'No se pudo ejecutar el procedimiento',
        ];

        return $response;

        }catch(Exception $e){
            $response = [
                'realizado'=>false,
                'archivo'=> 'Error archivo: '.$e->getFile(),
                'linea'=> 'Error linea: '.$e->getLine(),
                'mensaje'=> 'Error: '.$e->getMessage(),
            ];
            return $response;
        }
    }

    public static function eliminarTarea($id)
    {
        try{
        $response = DB::statement('CALL EliminarTarea(?)', [$id]);

        $response = [
            'realizado'=> $response,
            'archivo'=> '',
            'linea'=> '',
            'mensaje'=> 'No se pudo ejecutar el procedimiento',
        ];

        return $response;

        }catch(Exception $e){
            $response = [
                'realizado'=>false,
                'archivo'=> 'Error archivo: '.$e->getFile(),
                'linea'=> 'Error linea: '.$e->getLine(),
                'mensaje'=> 'Error: '.$e->getMessage(),
            ];
            return $response;
        }
    }

    public static function completarTarea($id)
    {
        try{
        $response = DB::statement('CALL CompletarTarea(?)', [$id]);

        $response = [
            'realizado'=> $response,
            'archivo'=> '',
            'linea'=> '',
            'mensaje'=> 'No se pudo ejecutar el procedimiento',
        ];

        return $response;

        }catch(Exception $e){
            $response = [
                'realizado'=>false,
                'archivo'=> 'Error archivo: '.$e->getFile(),
                'linea'=> 'Error linea: '.$e->getLine(),
                'mensaje'=> 'Error: '.$e->getMessage(),
            ];
            return $response;
        }
    }
}
