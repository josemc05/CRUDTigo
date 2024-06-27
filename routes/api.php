<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiCRUDController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(ApiCRUDController::class)->group(function (){
    Route::post('/cargar', 'cargarDatos');
    Route::post('/agregar', 'nuevaTarea');
    Route::delete('/eliminar/{id}', 'eliminarTarea');
    Route::patch('/completar/{id}', 'completarTarea');
    Route::put('/modificar/{id}', 'modificarTarea');
});
