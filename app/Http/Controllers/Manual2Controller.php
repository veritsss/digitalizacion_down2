<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Manual2Controller extends Controller
{
    public function index()
    {
        return view('manual2.manual2');
    }

    public function abecedario()
   {
        if (Auth::user()->role === 'Profesor') {
            return view('manual2.abecedario', [
                'isProfessor' => true,
            ]);
        } elseif (Auth::user()->role === 'Estudiante') {
            return view('manual2.abecedario', [
                'isProfessor' => false,
            ]);
        }
        abort(403, 'No tienes permisos para acceder a esta página.');
    }

    public function asociar()
    {
        if (Auth::user()->role === 'Profesor') {
            return view('manual2.asociar', [
                'isProfessor' => true,
            ]);
        } elseif (Auth::user()->role === 'Estudiante') {
            return view('manual2.asociar', [
                'isProfessor' => false,
            ]);
        }
        abort(403, 'No tienes permisos para acceder a esta página.');
    }

    public function carteles()
    {
        if (Auth::user()->role === 'Profesor') {
            return view('manual2.carteles', [
                'isProfessor' => true,
            ]);
        } elseif (Auth::user()->role === 'Estudiante') {
            return view('manual2.carteles', [
                'isProfessor' => false,
            ]);
        }
        abort(403, 'No tienes permisos para acceder a esta página.');
    }

    public function componer()
    {
        return view('manual2.componer');
    }

    public function librosPersonales()
    {
        if (Auth::user()->role === 'Profesor') {
            return view('manual2.libros-personales', [
                'isProfessor' => true,
            ]);
        } elseif (Auth::user()->role === 'Estudiante') {
            return view('manual2.libros-personales', [
                'isProfessor' => false,
            ]);
        }
        abort(403, 'No tienes permisos para acceder a esta página.');
    }


    public function seleccionAsociacion()
    {
        if (Auth::user()->role === 'Profesor') {
            return view('manual2.seleccion-asociacion', [
                'isProfessor' => true,
            ]);
        } elseif (Auth::user()->role === 'Estudiante') {
            return view('manual2.seleccion-asociacion', [
                'isProfessor' => false,
            ]);
        }
        abort(403, 'No tienes permisos para acceder a esta página.');
    }

    public function tarjetasFotos()
      {
        $images = \App\Models\Image::where(function($query) {
            $query->where('path', 'like', 'images/tarjetas-foto/%')
              ->orWhere('path', 'like', 'images/carteles/%');
        })->get();

        if (Auth::user()->role === 'Profesor') {
            return view('manual2.tarjetas-fotos', [
                'images' => $images,
                'isProfessor' => true,
            ]);
        } elseif (Auth::user()->role === 'Estudiante') {
            return view('manual2.tarjetas-fotos', [
                'images' => $images,
                'isProfessor' => false,
            ]);
        }

        abort(403, 'No tienes permisos para acceder a esta página.');
       }


    public function unir()
    {
        if (Auth::user()->role === 'Profesor') {
            return view('manual2.unir', [
                'isProfessor' => true,
            ]);
        } elseif (Auth::user()->role === 'Estudiante') {
            return view('manual2.unir', [
                'isProfessor' => false,
            ]);
        }
        abort(403, 'No tienes permisos para acceder a esta página.');
    }
}
