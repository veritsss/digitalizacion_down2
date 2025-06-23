<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Question;
use App\Models\QuestionImage;
use App\Models\StudentAnswer;
use App\Models\User;
class ProfessorE2Controller extends Controller
{
    // Mostrar la página para seleccionar imágenes para la pregunta
 public function selectQuestionImagesPageE2($folder = 'tarjetas-foto', $mode = 'images')
{
    // Obtener imágenes de tarjetas-foto y carteles
    $images = Image::where('path', 'like', 'images/tarjetas-foto/%')->get();
    $cartels = Image::where('path', 'like', 'images/carteles/%')->get();
    $asociar = Image::where('path', 'like', 'images/asociar/%')->get();
    $asociar2 = Image::where('path', 'like', 'images/cartelesAsociar/%')->get();
    $unir = Image::where('path', 'like', 'images/unir/%')->get();
    $unir2 = Image::where('path', 'like', 'images/cartelesUnir/%')->get();
    $seleccion = Image::where('path', 'like', 'images/seleccionyasociacion/%')->get();
    $seleccion2 = Image::where('path', 'like', 'images/Cartelesseleccion/%')->get();
    $componer = Image::where('path', 'like', 'images/componer/%')->get();
    $componer2 = Image::where('path', 'like', 'images/cartelesComponer/%')->get();

   return view('professor.etapa2.select-question-images', compact('images', 'cartels','asociar','asociar2','seleccion','seleccion2','unir','unir2','componer','componer2', 'folder', 'mode'));
}
    // Guardar las imágenes seleccionadas para la pregunta
    public function selectQuestionImagesE2(Request $request)
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

        return redirect()->route('professor.selectCorrectImagesPageE2', [
            'folder' => $folder,
            'mode' => $mode,
            'questionId' => $question->id,
        ])->with('message', 'Imágenes seleccionadas correctamente.')
  ->with('alert-type', 'success'); // Tipo de alerta (success, error, warning, info)
    }

    public function selectCorrectImagesE2($folder = 'pareoyseleccion', $mode = 'images', $questionId)
    {
        $questionImages = session('question_images', []);

        if (empty($questionImages)) {
            return redirect()->route('professor.selectQuestionImagesPageE2', ['folder' => $folder, 'mode' => $mode])
                ->with('message', 'No se seleccionaron imágenes para la pregunta.');
        }
        $question = Question::findOrFail($questionId);

        // Filtrar imágenes seleccionadas
        $images = Image::whereIn('id', $questionImages)
            ->where('path', 'like', 'images/tarjetas-foto/%')
            ->get();

        // Filtrar carteles seleccionados
        $cartels = Image::whereIn('id', $questionImages)
            ->where('path', 'like', 'images/carteles/%')
            ->get();
        $asociar = Image::whereIn('id', $questionImages)
            ->where('path', 'like', 'images/asociar/%')
            ->get();
        $asociar2 = Image::whereIn('id', $questionImages)
            ->where('path', 'like', 'images/cartelesAsociar/%')
            ->get();
        $unir = Image::whereIn('id', $questionImages)
            ->where('path', 'like', 'images/unir/%')
            ->get();
        $unir2 = Image::whereIn('id', $questionImages)
            ->where('path', 'like', 'images/cartelesUnir/%')
            ->get();
        $seleccion = Image::whereIn('id', $questionImages)
            ->where('path', 'like', 'images/seleccionyasociacion/%')
            ->get();
        $seleccion2 = Image::whereIn('id', $questionImages)
            ->where('path', 'like', 'images/Cartelesseleccion/%')
            ->get();
        $componer = Image::whereIn('id', $questionImages)
            ->where('path', 'like', 'images/componer/%')
            ->get();
        $componer2 = Image::whereIn('id', $questionImages)
            ->where('path', 'like', 'images/cartelesComponer/%')
            ->get();
        // Para los demás casos, solo envía lo necesario
      return view('professor.etapa2.select-correct-images', compact('images', 'cartels', 'asociar', 'asociar2', 'unir', 'unir2','seleccion','seleccion2','componer','componer2', 'folder', 'mode', 'question'));
    }
    // Guardar las imágenes correctas
public function saveCorrectImagesE2(Request $request, $folder)
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

            case 'asociar':
            case 'unir':
            case 'componer':

                $images = QuestionImage::where('question_id', $questionId)->with('image')->get();
                $this->resetImages($questionId, ['pair_id' => null]);
                $this->assignPairs($images); // Esto guarda el size en pair_id y marca como correctas
                return $this->jsonResponse(true, 'Las respuestas han sido guardadas correctamente.');
        case 'carteles':
        case 'seleccion':
            return $this->handleImagesOrPairs($request, $questionId, $mode);

        case 'tarjetas-foto':
            return $this->handleTarjetasFoto($request, $questionId);
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
        if ($mode === 'seleccionyasociacion') {
            $images = QuestionImage::where('question_id', $questionId)->with('image')->get();
                $this->resetImages($questionId, ['pair_id' => null]);
                $this->assignPairs($images); // Esto guarda el size en pair_id y marca como correctas
                return $this->jsonResponse(true, 'Las respuestas han sido guardadas correctamente.');

        }
    }
private function handleTarjetasFoto(Request $request, $questionId)
{
    // Validar los carteles asociados
    $request->validate([
        'cartel_ids' => 'required|array',
        'cartel_ids.*' => 'nullable|exists:images,id',
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
    $questionId = $images->first()->question_id ?? null;
    if ($questionId) {
        // Contar cuántas veces aparece cada pair_id
        $pairCounts = QuestionImage::where('question_id', $questionId)
            ->whereNotNull('pair_id')
            ->pluck('pair_id')
            ->countBy();

        // Si un pair_id aparece solo una vez, marcarlo como incorrecto
        foreach ($pairCounts as $pairId => $count) {
            if ($count === 1 && $pairId !== null) {
                QuestionImage::where('question_id', $questionId)
                    ->where('pair_id', $pairId)
                    ->update(['is_correct' => false]);
            }

        }
    }
    }
    private function jsonResponse($success, $message)
    {
        return response()->json(['success' => $success, 'message' => $message]);
    }
    public function selectConfigurationModeE2($folder = 'pareoyseleccion')
    {
    return view('professor.etapa2.select-configuration-mode', compact('folder'));
    }
}
