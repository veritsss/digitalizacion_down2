<?php
// filepath: c:\xampp\htdocs\digitalizacion_down21\app\Http\Controllers\HomeController.php

namespace App\Http\Controllers;
use App\Models\Question;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importar la clase Auth


class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Usar la clase Auth para obtener el usuario autenticado

        return view('welcome');
    }
    public function dashboard()
{
    if (Auth::user()->role === 'Profesor') {
        return view('dashboard', [
            'isProfessor' => true, // Indica que el usuario es un profesor
        ]);
    } elseif (Auth::user()->role === 'Estudiante') {
        return view('dashboard', [
            'isProfessor' => false, // Indica que el usuario es un estudiante
        ]);
    }
}
}
