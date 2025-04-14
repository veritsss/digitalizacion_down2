<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Manual3Controller extends Controller
{
    public function index()
    {
        return view('manual3.manual3');
    }

    public function composicionModelo()
    {
        return view('manual3.composicion-modelo');
    }

    public function reconocimientoSilabas()
    {
        return view('manual3.reconocimiento-silabas');
    }
}