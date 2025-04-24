<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Question;
use App\Models\QuestionImage;

class ProfessorController extends Controller
{
    // Mostrar la página para seleccionar imágenes para la pregunta
    public function selectQuestionImagesPage($folder = 'pareoyseleccion')
{
    // Construir el patrón de búsqueda para la carpeta
    $pathPattern = 'images/' . $folder . '/%';

    // Obtener las imágenes de la carpeta especificada
    $images = \App\Models\Image::where('path', 'like', $pathPattern)->get();

    return view('manual1.select-question-images', compact('images', 'folder'));
}

    // Guardar las imágenes seleccionadas para la pregunta
    public function selectQuestionImages(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255', // Validar que el título sea obligatorio
        'selected_images' => 'required|array',
        'selected_images.*' => 'exists:images,id',
    ]);

    $folder = $request->input('folder'); // Obtener el valor de la carpeta

    // Crear la pregunta con el tipo de actividad
    $question = \App\Models\Question::create([
        'title' => $request->input('title'),
        'type' => $folder, // Guardar el tipo de actividad
    ]);

    // Asociar las imágenes seleccionadas a la pregunta
    foreach ($request->selected_images as $imageId) {
        \App\Models\QuestionImage::create([
            'question_id' => $question->id,
            'image_id' => $imageId,
            'is_correct' => false, // Por defecto, no son correctas
        ]);
    }
        $request->validate([

            'selected_images' => 'required|array',
            'selected_images.*' => 'exists:images,id',
        ]);

        // Guardar las imágenes seleccionadas en la sesión
        session(['question_images' => $request->selected_images]);

        // Guardar el ID de la pregunta en la sesión
        session(['question_id' => $question->id]);

        return redirect()->route('professor.selectCorrectImagesPage', ['folder' => $folder])
            ->with('message', 'Imágenes seleccionadas correctamente.');
    }

    public function selectCorrectImages($folder = 'pareoyseleccion')
    {
        $questionImages = session('question_images', []);

        if (empty($questionImages)) {
            return redirect()->route('professor.selectQuestionImagesPage')->with('message', 'No se seleccionaron imágenes para la pregunta.');
        }

        $images = Image::whereIn('id', $questionImages)->get();

        return view('manual1.select-correct-images', compact('images', 'folder'));
    }
    // Guardar las imágenes correctas
    public function saveCorrectImages(Request $request)
    {

        $questionId = session('question_id');

        if (!$questionId) {
            return response()->json(['success' => false, 'message' => 'No se encontró la pregunta asociada.']);
        }

        // Obtener el tipo de actividad de la pregunta
        $question = Question::find($questionId);
        if (!$question) {
            return response()->json(['success' => false, 'message' => 'La pregunta no existe.']);
        }

        // PAREO
        if ($question->type === 'pareoyseleccion') {

            QuestionImage::where('question_id', $questionId)
                ->update(['is_correct' => false]);

            QuestionImage::where('question_id', $questionId)
                ->whereIn('image_id', $request->selected_images)
                ->update(['is_correct' => true]);

            return response()->json(['success' => true, 'message' => 'Respuestas correctas guardadas para pareo.']);
    }

        // ASOCIACIÓN
        elseif ($question->type === 'asociacion') {
            $request->validate([
                'pairs' => 'required|array', // Validar que se envíen pares
                'pairs.*' => 'integer|min:1', // Validar que los pares sean enteros
            ]);

            // Marcar todas las imágenes como incorrectas por defecto
            QuestionImage::where('question_id', $questionId)
                ->update(['is_correct' => false]);

            // Marcar los pares seleccionados como correctos
            foreach ($request->pairs as $imageId => $pairId) {
                QuestionImage::where('question_id', $questionId)
                    ->where('image_id', $imageId)
                    ->update([
                        'pair_id' => $pairId, // Asignar el pair_id
                        'is_correct' => true, // Marcar como correcta
                    ]);
            }

            return response()->json(['success' => true, 'message' => 'Respuestas correctas guardadas para asociación.']);
    }

        // CLASIFICACIÓN
        elseif ($question->type === 'clasificacion') {
             QuestionImage::where('question_id', $questionId)
             ->update(['is_correct' => false]);

         QuestionImage::where('question_id', $questionId)
             ->whereIn('image_id', $request->selected_images)
             ->update(['is_correct' => true]);

         return response()->json(['success' => true, 'message' => 'Respuestas correctas guardadas para clasificacion.']);
    }

        // PAREO POR IGUALDAD
        elseif ($question->type === 'pareoporigualdad') {
            $request->validate([
                'pairs' => 'required|array',
                'pairs.*' => 'integer|min:1',
            ]);


            QuestionImage::where('question_id', $questionId)
                ->update(['is_correct' => false]);


            foreach ($request->pairs as $imageId => $pairId) {
                QuestionImage::where('question_id', $questionId)
                    ->where('image_id', $imageId)
                    ->update([
                        'pair_id' => $pairId,
                        'is_correct' => true,
                    ]);
            }

        return response()->json(['success' => true, 'message' => 'Respuestas correctas guardadas para pareo por igualdad.']);

    }
        //SERIES
        elseif ($question->type === 'series') {

            QuestionImage::where('question_id', $questionId)
            ->update(['is_correct' => false]);

        QuestionImage::where('question_id', $questionId)
            ->whereIn('image_id', $request->selected_images)
            ->update(['is_correct' => true]);

        return response()->json(['success' => true, 'message' => 'Respuestas correctas guardadas para Series.']);
    }

    return response()->json(['success' => false, 'message' => 'Tipo de actividad no reconocido.']);
}

}
