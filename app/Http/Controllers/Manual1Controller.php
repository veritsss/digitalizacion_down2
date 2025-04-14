<?php

namespace App\Http\Controllers;
 
use Illuminate\Support\Facades\Auth;

class Manual1Controller extends Controller
{
    public function index()
    {
        return view('manual1.manual1');
    }

    public function pareoSeleccionDibujo()
    {
     // Filtrar imágenes cuyo path contenga 'images/pareoyseleccion/'
     $images = \App\Models\Image::where('path', 'like', 'images/pareoyseleccion/%')->get();

     if (Auth::user()->role === 'Profesor') {
         return view('manual1.pareo-seleccion-dibujo', [
             'images' => $images,
             'isProfessor' => true,
         ]);
     } elseif (Auth::user()->role === 'Estudiante') {
         return view('manual1.pareo-seleccion-dibujo', [
             'images' => $images,
             'isProfessor' => false,
         ]);
     }
 
     abort(403, 'No tienes permisos para acceder a esta página.');
    }





    public function asociacion()
    {
        return view('manual1.asociacion');
    }

    public function clasificacion()
    {
        return view('manual1.clasificacion');
    }

    public function pareoIgualdad()
    {
        return view('manual1.pareo-igualdad');
    }

    public function series()
    {
        return view('manual1.series');
    }
}