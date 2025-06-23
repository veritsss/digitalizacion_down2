<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Image;

class Manual2Controller extends Controller
{
   public function index()
    {
         if (Auth::user()->role === 'Profesor') {
        return view('manual2.manual2', [
            'isProfessor' => true,
        ]);
    } elseif (Auth::user()->role === 'Estudiante') {
        return view('manual2.manual2', [
            'isProfessor' => false,
        ]);
    }
    abort(403, 'No tienes permisos para acceder a esta página.');
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
    $asociar = \App\Models\Image::where('path', 'like', 'images/asociar/%')->get();

    if (Auth::user()->role === 'Profesor') {
        return view('manual2.asociar', [
            'images' => $asociar,
            'isProfessor' => true,
        ]);
    } elseif (Auth::user()->role === 'Estudiante') {
        return view('manual2.asociar', [
            'images' => $asociar,
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
        if (Auth::user()->role === 'Profesor') {
            return view('manual2.componer', [
                'isProfessor' => true,
            ]);
        } elseif (Auth::user()->role === 'Estudiante') {
            return view('manual2.componer', [
                'isProfessor' => false,
            ]);
        }
        abort(403, 'No tienes permisos para acceder a esta página.');
    }

    public function librosPersonales()
    {
        $user = Auth::user();
        if (Auth::user()->role === 'Profesor') {
            return view('manual2.libros-personales', [
                'isProfessor' => true,
            ]);
        } elseif (Auth::user()->role === 'Estudiante') {
            return view('manual2.libros-personales', [
                'isProfessor' => false,
                'studentId' => $user->id,
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
        $unir = \App\Models\Image::where('path', 'like', 'images/unir/%')->get();

         if (Auth::user()->role === 'Profesor') {
            return view('manual2.unir', [
                'images' => $unir,
                'isProfessor' => true,
            ]);
        } elseif (Auth::user()->role === 'Estudiante') {
            return view('manual2.unir', [
                'images' => $unir,
                'isProfessor' => false,
            ]);
        }
        abort(403, 'No tienes permisos para acceder a esta página.');
    }
}
