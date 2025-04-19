<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Manual4Controller extends Controller
{
    public function index()
    {
        return view('manual4.manual4');
    }

    public function completar()
    {
        return view('manual4.completar');
    }

    public function componerOraciones()
    {
        return view('manual4.componer-oraciones');
    }

    public function secuenciarTextos()
    {
        return view('manual4.secuenciar-textos');
    }

    public function seleccionar()
    {
        return view('manual4.seleccionar');
    }
}
