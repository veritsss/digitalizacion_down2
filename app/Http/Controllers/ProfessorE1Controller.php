<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Question;
use App\Models\QuestionImage;
use App\Models\StudentAnswer;
use App\Models\User;

class ProfessorE1Controller extends Controller
{
    // Mostrar la página para seleccionar imágenes para la pregunta
 public function selectQuestionImagesPageE1($folder = 'pareoyseleccion', $mode = 'images')
{
    // Construir el patrón de búsqueda para la carpeta
    $pathPattern = 'images/' . $folder . '/%';

    // Filtrar las imágenes según el usage_type
    $images = Image::where('path', 'like', $pathPattern)
                   ->whereRaw("FIND_IN_SET('$mode', usage_type)") // Filtrar por usage_type
                   ->get();

    return view('professor.etapa1.select-question-images', compact('images', 'folder', 'mode'));
}

    // Guardar las imágenes seleccionadas para la pregunta
    public function selectQuestionImagesE1(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'selected_images' => 'required|array',
        'selected_images.*' => 'exists:images,id',
    ]);

    $folder = $request->input('folder'); // Obtener el valor de la carpeta
    $mode = $request->input('mode');
    // Crear la pregunta con el tipo de actividad
    $question = Question::create([
        'title' => $request->input('title'),
        'type' => $folder, // Guardar el tipo de actividad
        'mode' => $mode,
    ]);

    // Asociar las imágenes seleccionadas a la pregunta
    foreach ($request->selected_images as $imageId) {
       QuestionImage::create([
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

        return redirect()->route('professor.selectCorrectImagesPageE1', [
            'folder' => $folder,
            'mode' => $mode,
            'questionId' => $question->id,
        ])->with('message', 'Imágenes seleccionadas correctamente.')
  ->with('alert-type', 'success'); // Tipo de alerta (success, error, warning, info)
    }

    public function selectCorrectImagesE1($folder = 'pareoyseleccion', $mode = 'images', $questionId)
    {
        $questionImages = session('question_images', []);

        if (empty($questionImages)) {
            return redirect()->route('professor.selectQuestionImagesPageE1', ['folder' => $folder, 'mode' => $mode])
                ->with('message', 'No se seleccionaron imágenes para la pregunta.');
        }
        $question = Question::findOrFail($questionId);
        $images = Image::whereIn('id', $questionImages)->get();

        return view('professor.etapa1.select-correct-images', compact('images', 'folder', 'mode', 'question'));
    }
    // Guardar las imágenes correctas
    public function saveCorrectImagesE1(Request $request, $folder)
    {
        $questionId = session('question_id');

        if (!$questionId) {
            return $this->jsonResponse(false, 'No se encontró la pregunta asociada.');
        }

        $question = Question::find($questionId);
        if (!$question) {
            return $this->jsonResponse(false, 'La pregunta no existe.');
        }

        $mode = $request->input('mode');

        // Manejar diferentes tipos de preguntas
        switch ($question->type) {
            case 'pareoyseleccion':
            case 'asociacion':
            case 'clasificacionColor':
            case 'clasificacionHabitat':
            case 'clasificacionCategoria':
            case 'pareoporigualdad':

                return $this->handleImagesOrPairs($request, $questionId, $mode);

            case 'seriesTamaño':
                return $this->handleSeriesTamaño($request, $questionId);

            case 'seriesTemporales':
                return $this->handleSeriesTemporales($questionId);

            case 'tarjetas-foto':
            return $this->handleTarjetasFoto($request, $questionId);

            default:
                return $this->jsonResponse(false, 'La actividad que intentas realizar no existe.');
        }
    }

    private function handleImagesOrPairs(Request $request, $questionId, $mode)
    {
        if ($mode === 'images') {
            $this->validateImages($request);
            $this->updateImages($questionId, $request->selected_images);
            return $this->jsonResponse(true, 'Respuestas correctas guardadas.');
        }

        if ($mode === 'pairs') {
            $images = QuestionImage::where('question_id', $questionId)->with('image')->get();
            $this->resetImages($questionId, ['pair_id' => null]);
            $this->assignPairs($images);
            return $this->jsonResponse(true, 'Respuestas correctas guardadas.');
        }
    }

    private function handleSeriesTamaño(Request $request, $questionId)
    {
        $request->validate([
            'correct_group' => 'required|in:1,2,3',
        ]);

        $correctGroup = $request->input('correct_group');
        $this->resetImages($questionId);
        QuestionImage::where('question_id', $questionId)
            ->whereHas('image', function ($query) use ($correctGroup) {
                $query->where('size', $correctGroup);
            })
            ->update(['is_correct' => true]);

        Question::find($questionId)->update(['correct_group' => $correctGroup]);
        return $this->jsonResponse(true, 'Respuestas correctas guardadas.');
    }

    private function handleSeriesTemporales($questionId)
    {
        QuestionImage::where('question_id', $questionId)->update(['is_correct' => true]);
        return $this->jsonResponse(true, 'Respuestas correctas guardadas.');
    }
private function handleTarjetasFoto(Request $request, $questionId)
{
    // Validar los carteles asociados
    $request->validate([
        'cartel_ids' => 'required|array',
        'cartel_ids.*' => 'exists:cartels,id',
    ]);

    // Reiniciar las imágenes de la pregunta (marcar todas como no correctas)
    $this->resetImages($questionId);

    // Obtener las imágenes asociadas a la pregunta
    $images = QuestionImage::where('question_id', $questionId)->get();

    foreach ($images as $image) {
        $cartelId = $request->input("cartel_ids.{$image->image_id}");

        // Actualizar cada imagen con el cartel asociado
        $image->update([
            'is_correct' => true, // Todas las imágenes son correctas por defecto
            'cartel_id' => $cartelId, // Guardar el ID del cartel asociado
        ]);
    }

    return $this->jsonResponse(true, 'Respuestas correctas y carteles asociados guardados correctamente.');
}
    private function validateImages(Request $request)
    {
        $request->validate([
            'selected_images' => 'required|array',
            'selected_images.*' => 'exists:question_images,image_id',
        ]);
    }

    private function updateImages($questionId, $selectedImages)
    {
        $this->resetImages($questionId);
        QuestionImage::where('question_id', $questionId)
            ->whereIn('image_id', $selectedImages)
            ->update(['is_correct' => true]);
    }

    private function resetImages($questionId, $additionalUpdates = [])
    {
        QuestionImage::where('question_id', $questionId)->update(array_merge(['is_correct' => false], $additionalUpdates));
    }

    private function assignPairs($images)
    {
        foreach ($images as $questionImage) {
            QuestionImage::where('id', $questionImage->id)
                ->update([
                    'pair_id' => $questionImage->image->size,
                    'is_correct' => true,
                ]);
        }
    }

    private function jsonResponse($success, $message)
    {
        return response()->json(['success' => $success, 'message' => $message]);
    }
    public function selectConfigurationModeE1($folder = 'pareoyseleccion')
{
    return view('professor.etapa1.select-configuration-mode', compact('folder'));
}


}






