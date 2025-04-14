<?php

namespace App\Http\Controllers;

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
        return view('manual2.carteles');
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
        return view('manual2.tarjetas-fotos');
    }

    public function unir()
    {
        return view('manual2.unir');
    }
}