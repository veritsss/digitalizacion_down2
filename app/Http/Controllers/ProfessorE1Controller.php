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
public function viewStudentResponses(Request $request, $studentId)
{
    $student = User::findOrFail($studentId);

    // Obtener el tipo de pregunta seleccionado
    $type = $request->input('type');

    // Obtener el orden seleccionado (ascendente o descendente)
    $order = $request->input('order', 'desc'); // Por defecto, descendente

    // Obtener el filtro por nombre (si existe)
    $filter = $request->input('filter');

    // Consultar las respuestas del estudiante
    $responsesQuery = StudentAnswer::where('student_id', $studentId)
        ->when($type, function ($query, $type) {
            return $query->whereHas('question', function ($q) use ($type) {
                $q->where('type', $type);
            });
        })
        ->when($filter, function ($query, $filter) {
            return $query->whereHas('question', function ($q) use ($filter) {
                $q->where('title', 'like', "%$filter%");
            });
        })
        ->orderBy('created_at', $order);

    $responses = $responsesQuery->get()->groupBy('question_id');

    // Calcular estadísticas para cada pregunta
    $statistics = [];
    foreach ($responses as $questionId => $answers) {
        $totalImages = QuestionImage::where('question_id', $questionId)->count();
        $totalCorrectImages = QuestionImage::where('question_id', $questionId)->where('is_correct', true)->count();
        $studentCorrectAnswers = $answers->where('is_correct', true)->count();

        $statistics[$questionId] = [
            'total_images' => $totalImages,
            'total_correct_images' => $totalCorrectImages,
            'student_correct_answers' => $studentCorrectAnswers,
        ];
    }

    return view('manual1.view-student-responses', compact('student', 'responses', 'type', 'order', 'filter', 'statistics'));
}

public function searchStudents(Request $request)
{
    $search = $request->input('search');

    // Buscar estudiantes por nombre, RUT o ID
    $students = User::where('role', 'Estudiante')
        ->when($search, function ($query, $search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('rut', 'like', "%$search%"); // Buscar por RUT
        })
        ->get();

    // Si es una solicitud AJAX, devolver los resultados como JSON
    if ($request->ajax()) {
        return response()->json($students);
    }

    // Si no es AJAX, cargar la vista con todos los estudiantes
    return view('manual1.search-students', compact('students'));
}
public function saveTemporalSequence(Request $request, $folder)
{
    $request->validate([
        'order' => 'required|array', // Validar que se envíe un array de órdenes
        'order.*' => 'integer|min:1', // Validar que cada orden sea un número entero mayor o igual a 1
    ]);

    $questionId = $request->input('question_id'); // Asegúrate de que el ID de la pregunta esté disponible

    // Reiniciar el orden de todas las imágenes asociadas a la pregunta
    QuestionImage::where('question_id', $questionId)->update(['sequence_order' => null]);

    // Guardar el orden asignado a cada imagen
    foreach ($request->input('order') as $imageId => $order) {
        QuestionImage::where('question_id', $questionId)
            ->where('image_id', $imageId)
            ->update(['sequence_order' => $order]);
    }

    return redirect()->back()->with('success', 'Respuestas correctas guardadas.');
}
public function validateTemporalSequence(Request $request, $questionId)
{
    $request->validate([
        'selected_images' => 'required|array', // Validar que se envíen imágenes seleccionadas
        'selected_images.*' => 'exists:question_images,image_id', // Validar que las imágenes existan
    ]);

    // Obtener la secuencia correcta basada en el campo `sequence_order`
    $correctSequence = QuestionImage::where('question_id', $questionId)
        ->orderBy('sequence_order', 'asc') // Ordenar por el campo `sequence_order`
        ->pluck('image_id')
        ->toArray();

    // Comparar la secuencia seleccionada con la secuencia correcta
    if ($request->input('selected_images') === $correctSequence) {
        return response()->json(['success' => true, 'message' => 'Secuencia correcta.']);
    }

    return response()->json(['success' => false, 'message' => 'La secuencia es incorrecta.']);
}
public function index()
{
    $total_questions = Question::count();

    $students = User::where('role', 'estudiante')->get();

    $students = $students->filter(function($student) use ($total_questions) {
        // IDs de preguntas que respondió el estudiante
        $answered_question_ids = StudentAnswer::where('student_id', $student->id)
            ->pluck('question_id')
            ->unique();

        if ($answered_question_ids->isEmpty()) {
            return false;
        }

        // Total de imágenes correctas posibles solo en las preguntas respondidas
        $total_correct_images = QuestionImage::whereIn('question_id', $answered_question_ids)
            ->where('is_correct', 1)
            ->count();

        // Total de aciertos del estudiante
        $student_correct = StudentAnswer::where('student_id', $student->id)
            ->where('is_correct', 1)
            ->count();

        // Cantidad de preguntas respondidas
        $student->questions_answered = $answered_question_ids->count();
        $student->questions_total = $total_questions;

        $student->total_correct = $student_correct;
        $student->total_possible = $total_correct_images;
        $student->accuracy = $total_correct_images > 0
            ? round(($student_correct / $total_correct_images) * 100, 2)
            : 0;

        return true;
    });

    return view('professor.dashboard', ['students' => $students]);
}
public function detalle($id)
{
    $student = User::findOrFail($id);

    // Obtener los tipos de pregunta
    $types = Question::distinct()->pluck('type');

    $detalles = [];

    foreach ($types as $type) {
        // IDs de preguntas de este tipo
        $question_ids = Question::where('type', $type)->pluck('id');

        // Total de preguntas de este tipo
        $total_preguntas = $question_ids->count();

        // Preguntas respondidas por el estudiante de este tipo
        $preguntas_respondidas = StudentAnswer::where('student_id', $student->id)
            ->whereIn('question_id', $question_ids)
            ->pluck('question_id')
            ->unique()
            ->count();
        $preguntas_respondidas_ids = StudentAnswer::where('student_id', $student->id)
            ->whereIn('question_id', $question_ids)
            ->pluck('question_id')
            ->unique();

        $preguntas_respondidas = $preguntas_respondidas_ids->count();

        // Solo imágenes correctas de preguntas respondidas
        $imagenes_correctas_ids = QuestionImage::whereIn('question_id', $preguntas_respondidas_ids)
            ->where('is_correct', 1)
            ->pluck('id');

        // Total de imágenes correctas posibles en esas preguntas
        $total_imagenes = QuestionImage::whereIn('question_id', $question_ids)
            ->where('is_correct', 1)
            ->count();

        // Imágenes respondidas por el estudiante (de esas preguntas)
        $imagenes_respondidas = StudentAnswer::where('student_id', $student->id)
            ->whereIn('question_id', $question_ids)
            ->count();

        // Imágenes correctas respondidas
        $imagenes_correctas = StudentAnswer::where('student_id', $student->id)
            ->whereIn('question_id', $question_ids)
            ->where('is_correct', 1)
            ->count();

        // Imágenes incorrectas respondidas
        $imagenes_incorrectas = StudentAnswer::where('student_id', $student->id)
            ->whereIn('question_id', $question_ids)
            ->where('is_correct', 0)

            ->count();


          $imagenes_correctas_respondidas_ids = StudentAnswer::where('student_id', $student->id)
            ->whereIn('question_id', $preguntas_respondidas_ids)
            ->whereIn('image_id', $imagenes_correctas_ids)
            ->pluck('image_id')
            ->unique();

        $omitidas = ($imagenes_correctas_ids->diff($imagenes_correctas_respondidas_ids)->count()) -  $imagenes_respondidas;

        if ($total_preguntas > 0) {
            $detalles[] = [
                'type' => $type,
                'total_preguntas' => $total_preguntas,
                'preguntas_respondidas' => $preguntas_respondidas,
                'total_imagenes' => $total_imagenes,
                'imagenes_respondidas' => $imagenes_respondidas,
                'imagenes_correctas' => $imagenes_correctas,
                'imagenes_incorrectas' => $imagenes_incorrectas,
                'omitidas' => $omitidas,
                'porcentaje' => $imagenes_respondidas > 0
                    ? round(($imagenes_correctas / $imagenes_respondidas) * 100, 2)
                    : 0,
            ];
        }
    }

    return view('professor.student-detail', compact('student', 'detalles'));

}

public function deleteQuestion($id)
{
    $question = Question::findOrFail($id);
    $question->delete();

    session()->flash('message', 'La pregunta ha sido eliminada correctamente.');
    session()->flash('alert-type', 'success'); // Tipo de alerta (success, error, warning, info)
    return redirect()->back();
}
public function listQuestions(Request $request)
{
    $query = Question::with('images'); // Cargar las imágenes asociadas a las preguntas

    // Filtrar por título
    if ($request->filled('title')) {
        $query->where('title', 'like', '%' . $request->title . '%');
    }

    // Filtrar por tipo
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    // Ordenar por ID descendente y paginar
    $questions = $query->orderBy('id', 'desc')->paginate(50);

    return view('professor.questions.list', compact('questions'));
}

}






