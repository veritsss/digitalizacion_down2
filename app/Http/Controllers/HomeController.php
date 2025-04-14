<?php
// filepath: c:\xampp\htdocs\digitalizacion_down21\app\Http\Controllers\HomeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importar la clase Auth


class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Usar la clase Auth para obtener el usuario autenticado

        return view('welcome');
    }
}   