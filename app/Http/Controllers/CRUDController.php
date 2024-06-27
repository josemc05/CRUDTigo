<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CRUDController extends Controller
{
    public function showCRUD(){
        return view('CRUD.tareas');
    }
}
