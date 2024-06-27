<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Tareas extends Model
{
    use HasFactory;

    protected $table = 'tareas';


    public static function crearTarea($tarea)
    {

        $response = DB::statement('CALL CrearTarea(?)', [$tarea]);

        return $response;

    }

    public static function modificarTarea($id, $tarea)
    {
        $response = DB::statement('CALL ModificarTarea(?, ?)', [$id, $tarea]);

        return $response;
    }

    public static function eliminarTarea($id)
    {
        $response = DB::statement('CALL EliminarTarea(?)', [$id]);

        return $response;
    }

    public static function completarTarea($id)
    {
        $response = DB::statement('CALL CompletarTarea(?)', [$id]);

        return $response;
    }
}
