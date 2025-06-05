<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cartel;
use App\Models\Image;

class CartelController extends Controller
{
    // Mostrar la página para gestionar carteles
    public function index()
    {
        $carteles = Cartel::all();
        return view('manual1.manage-carteles', compact('carteles'));
    }

    // Guardar un nuevo cartel
    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:255',
        ]);

        Cartel::create(['text' => $request->text]);

        return redirect()->back()->with('success', 'Cartel creado correctamente.');
    }

    // Parear dos carteles
    public function pair(Request $request)
    {
        $request->validate([
            'cartel1' => 'required|exists:carteles,id',
            'cartel2' => 'required|exists:carteles,id',
        ]);

        // Aquí puedes guardar la relación entre los carteles en una tabla intermedia si es necesario

        return redirect()->back()->with('success', 'Carteles pareados correctamente.');
    }

    // Asociar tarjetas de foto a un cartel
    public function associateTarjetaFoto(Request $request)
    {
        $request->validate([
            'cartel_id' => 'required|exists:cartels,id',
            'tarjetas_foto' => 'required|array',
            'tarjetas_foto.*' => 'exists:images,id',
        ]);

        foreach ($request->tarjetas_foto as $tarjetaId) {
            $tarjeta = Image::findOrFail($tarjetaId);
            $tarjeta->cartel_id = $request->cartel_id;
            $tarjeta->save();
        }

        return redirect()->back()->with('success', 'Asociación guardada correctamente.');
    }

    // Mostrar el formulario para asociar carteles y tarjetas
    public function showAssociateForm()
    {
        $carteles = Cartel::all(); // Obtener todos los carteles
        $tarjetasFoto = Image::where('folder', 'tarjetas-foto')->get(); // Obtener todas las tarjetas-foto

        return view('manual1.associate-carteles-tarjetas', compact('carteles', 'tarjetasFoto'));
    }
}
