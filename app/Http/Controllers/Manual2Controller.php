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
        return view('manual2.abecedario');
    }

    public function asociar()
    {
        return view('manual2.asociar');
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
        return view('manual2.libros-personales');
    }

    public function seleccionAsociacion()
    {
        return view('manual2.seleccion-asociacion');
    }

    public function tarjetasFotos()
      {
        $images = \App\Models\Image::where('path', 'like', 'images/tarjetas-foto/%')->get();

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
        return view('manual2.unir');
    }
}
