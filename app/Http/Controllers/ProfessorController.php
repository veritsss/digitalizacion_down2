<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ProfessorController extends Controller
{
    // Mostrar la página para seleccionar imágenes para la pregunta
    public function selectQuestionImagesPage()
    {
        $images = \App\Models\Image::where('path', 'like', 'images/pareoyseleccion/%')->get();
        return view('manual1.select-question-images', compact('images'));
    }

    // Guardar las imágenes seleccionadas para la pregunta
    public function selectQuestionImages(Request $request)
    {
        $request->validate([
            'selected_images' => 'required|array',
            'selected_images.*' => 'exists:images,id',
        ]);

        // Guardar las imágenes seleccionadas en la sesión
        session(['question_images' => $request->selected_images]);

        return redirect()->route('professor.selectCorrectImagesPage')->with('message', 'Imágenes seleccionadas correctamente.');
    }

    // Mostrar la página para seleccionar las imágenes correctas
    public function selectCorrectImages()
    {
        $questionImages = session('question_images', []);

        if (empty($questionImages)) {
            return redirect()->route('professor.selectQuestionImagesPage')->with('message', 'No se seleccionaron imágenes para la pregunta.');
        }

        $images = Image::whereIn('id', $questionImages)->get();

        return view('manual1.select-correct-images', compact('images'));
    }

    // Guardar las imágenes correctas
    public function saveCorrectImages(Request $request)
    {
        $request->validate([
            'selected_images' => 'required|array',
            'selected_images.*' => 'exists:images,id',
        ]);
    
        // Desmarcar todas las imágenes como correctas
        Image::query()->update(['is_correct' => false]);
    
        // Marcar las imágenes seleccionadas como correctas
        foreach ($request->selected_images as $imageId) {
            $image = Image::find($imageId);
            $image->is_correct = true;
            $image->save();
        }
    
        return response()->json(['success' => true]);
    }
}