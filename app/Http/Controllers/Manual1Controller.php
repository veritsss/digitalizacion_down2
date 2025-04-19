<?php

namespace App\Http\Controllers;
use App\Models\Question;

use Illuminate\Support\Facades\Auth;

class Manual1Controller extends Controller
{
    public function index()
    {
        return view('manual1.manual1');
    }
    public function showManual()
    {
        // Obtener la primera pregunta disponible
        $firstQuestion = Question::first();

        return view('manual1.manual1', compact('firstQuestion'));
    }

    public function pareoSeleccionDibujo()
    {

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
            // Filtrar imágenes cuyo path contenga 'images/pareoyseleccion/'
            $images = \App\Models\Image::where('path', 'like', 'images/asociacion/%')->get();

            if (Auth::user()->role === 'Profesor') {
                return view('manual1.asociacion', [
                    'images' => $images,
                    'isProfessor' => true,
                ]);
            } elseif (Auth::user()->role === 'Estudiante') {
                return view('manual1.asociacion', [
                    'images' => $images,
                    'isProfessor' => false,
                ]);
            }

            abort(403, 'No tienes permisos para acceder a esta página.');
           }

    public function clasificacion()
    {
        $images = \App\Models\Image::where('path', 'like', 'images/clasificacion/%')->get();

        if (Auth::user()->role === 'Profesor') {
            return view('manual1.clasificacion', [
                'images' => $images,
                'isProfessor' => true,
            ]);
        } elseif (Auth::user()->role === 'Estudiante') {
            return view('manual1.clasificacion', [
                'images' => $images,
                'isProfessor' => false,
            ]);
        }

        abort(403, 'No tienes permisos para acceder a esta página.');
       }

    public function pareoIgualdad()
    {
        $images = \App\Models\Image::where('path', 'like', 'images/pareoporigualdad/%')->get();

        if (Auth::user()->role === 'Profesor') {
            return view('manual1.pareo-igualdad', [
                'images' => $images,
                'isProfessor' => true,
            ]);
        } elseif (Auth::user()->role === 'Estudiante') {
            return view('manual1.pareo-igualdad', [
                'images' => $images,
                'isProfessor' => false,
            ]);
        }

        abort(403, 'No tienes permisos para acceder a esta página.');
       }

    public function series()
    {
        $images = \App\Models\Image::where('path', 'like', 'images/series/%')->get();

        if (Auth::user()->role === 'Profesor') {
            return view('manual1.series', [
                'images' => $images,
                'isProfessor' => true,
            ]);
        } elseif (Auth::user()->role === 'Estudiante') {
            return view('manual1.series', [
                'images' => $images,
                'isProfessor' => false,
            ]);
        }

        abort(403, 'No tienes permisos para acceder a esta página.');
       }
}
