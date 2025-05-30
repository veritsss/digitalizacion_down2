<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Question;
use App\Models\QuestionImage;
use App\Models\StudentAnswer;
use App\Models\User;

class ProfessorController extends Controller
{
    // Mostrar la página para seleccionar imágenes para la pregunta
    public function selectQuestionImagesPage($folder = 'pareoyseleccion', $mode = 'images')
{
    // Construir el patrón de búsqueda para la carpeta
    $pathPattern = 'images/' . $folder . '/%';

    // Obtener las imágenes de la carpeta especificada
    $images = Image::where('path', 'like', $pathPattern)->get();

    return view('manual1.select-question-images', compact('images', 'folder', 'mode'));
}

    // Guardar las imágenes seleccionadas para la pregunta
    public function selectQuestionImages(Request $request)
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

        return redirect()->route('professor.selectCorrectImagesPage', ['folder' => $folder, 'mode' => $mode,
        'questionId' => $question->id,])
            ->with('message', 'Imágenes seleccionadas correctamente.');
    }

    public function selectCorrectImages($folder = 'pareoyseleccion', $mode = 'images', $questionId)
    {
        $questionImages = session('question_images', []);

        if (empty($questionImages)) {
            return redirect()->route('professor.selectQuestionImagesPage', ['folder' => $folder, 'mode' => $mode])
                ->with('message', 'No se seleccionaron imágenes para la pregunta.');
        }
        $question = Question::findOrFail($questionId);
        $images = Image::whereIn('id', $questionImages)->get();

        return view('manual1.select-correct-images', compact('images', 'folder', 'mode', 'question'));
    }
    // Guardar las imágenes correctas
    public function saveCorrectImages(Request $request, $folder)
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
        $mode = $request->input('mode');



        // PAREO, SELECCIÓN Y DIBUJO
        if ($question->type === 'pareoyseleccion') {

            if ($mode === 'images') {
                $request->validate([
                    'selected_images' => 'required|array',
                    'selected_images.*' => 'exists:question_images,image_id',
                ]);

                QuestionImage::where('question_id', $questionId)->update(['is_correct' => false]);
                QuestionImage::where('question_id', $questionId)
                    ->whereIn('image_id', $request->selected_images)
                    ->update(['is_correct' => true]);

                return response()->json(['success' => true, 'message' => 'Respuestas correctas guardadas.']);
            }

            elseif ($mode === 'pairs') {
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

                return response()->json(['success' => true, 'message' => 'Respuestas correctas guardadas. ']);
            }
        }

        // ASOCIACIÓN
        elseif ($question->type === 'asociacion') {
            if ($mode === 'images') {
                $request->validate([
                    'selected_images' => 'required|array',
                    'selected_images.*' => 'exists:question_images,image_id',
                ]);

                QuestionImage::where('question_id', $questionId)->update(['is_correct' => false]);
                QuestionImage::where('question_id', $questionId)
                    ->whereIn('image_id', $request->selected_images)
                    ->update(['is_correct' => true]);

                return response()->json(['success' => true, 'message' => 'Respuestas correctas guardadas.']);
            }

            elseif ($mode === 'pairs') {
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

            return response()->json(['success' => true, 'message' => 'Respuestas correctas guardadas.']);
    }
        }
        // CLASIFICACIÓN POR COLOR
        elseif ($question->type === 'clasificacionColor') {
        if ($mode === 'images') {
            $request->validate([
                'selected_images' => 'required|array',
                'selected_images.*' => 'exists:question_images,image_id',
            ]);

            QuestionImage::where('question_id', $questionId)->update(['is_correct' => false]);
            QuestionImage::where('question_id', $questionId)
                ->whereIn('image_id', $request->selected_images)
                ->update(['is_correct' => true]);

            return response()->json(['success' => true, 'message' => 'Respuestas correctas guardadas.']);
        }

        elseif ($mode === 'pairs') {
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

         return response()->json(['success' => true, 'message' => 'Respuestas correctas guardadas.']);
    }
}
        // CLASIFICACIÓN POR HABITAT
        elseif ($question->type === 'clasificacionHabitat') {
            if ($mode === 'images') {
                $request->validate([
                    'selected_images' => 'required|array',
                    'selected_images.*' => 'exists:question_images,image_id',
                ]);

                QuestionImage::where('question_id', $questionId)->update(['is_correct' => false]);
                QuestionImage::where('question_id', $questionId)
                    ->whereIn('image_id', $request->selected_images)
                    ->update(['is_correct' => true]);

                return response()->json(['success' => true, 'message' => 'Respuestas correctas guardadas.']);
            }

            elseif ($mode === 'pairs') {
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

            return response()->json(['success' => true, 'message' => 'Respuestas correctas guardadas.']);
        }
    }
        // CLASIFICACIÓN POR CATEGORÍA
        elseif ($question->type === 'clasificacionCategoria') {
            if ($mode === 'images') {
                $request->validate([
                    'selected_images' => 'required|array',
                    'selected_images.*' => 'exists:question_images,image_id',
                ]);

                QuestionImage::where('question_id', $questionId)->update(['is_correct' => false]);
                QuestionImage::where('question_id', $questionId)
                    ->whereIn('image_id', $request->selected_images)
                    ->update(['is_correct' => true]);

                return response()->json(['success' => true, 'message' => 'Respuestas correctas guardadas.']);
            }

            elseif ($mode === 'pairs') {
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

            return response()->json(['success' => true, 'message' => 'Respuestas correctas guardadas.']);
        }
        }

        // PAREO POR IGUALDAD
        elseif ($question->type === 'pareoporigualdad') {
            if ($mode === 'images') {
                $request->validate([
                    'selected_images' => 'required|array',
                    'selected_images.*' => 'exists:question_images,image_id',
                ]);

                QuestionImage::where('question_id', $questionId)->update(['is_correct' => false]);
                QuestionImage::where('question_id', $questionId)
                    ->whereIn('image_id', $request->selected_images)
                    ->update(['is_correct' => true]);

                return response()->json(['success' => true, 'message' => 'Respuestas correctas guardadas.']);
            }

            elseif ($mode === 'pairs') {
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

        return response()->json(['success' => true, 'message' => 'Respuestas correctas guardadas.']);

    }
    }
        // SERIES POR TAMAÑO
        elseif ($question->type === 'seriesTamaño'){
            if ($mode === 'images') {
                $request->validate([
                    'correct_group' => 'required|in:1,2,3', // Validar que el grupo correcto sea 1, 2 o 3
                ]);

                $correctGroup = $request->input('correct_group');

                // Reiniciar el estado de todas las imágenes asociadas a la pregunta
                QuestionImage::where('question_id', $questionId)->update(['is_correct' => false]);

                // Marcar como correctas las imágenes que pertenecen al grupo seleccionado
                QuestionImage::where('question_id', $questionId)
                    ->whereHas('image', function ($query) use ($correctGroup) {
                        $query->where('size', $correctGroup);
                    })
                    ->update(['is_correct' => true]);

                // Guardar el grupo correcto en la pregunta
                $question->update(['correct_group' => $correctGroup]);

                return response()->json(['success' => true, 'message' => 'Respuestas correctas guardadas.']);
            }
        }
    //SERIES TEMPORALES
    elseif ($question->type === 'seriesTemporales') {
    if ($mode === 'seriesTemporales') {
        $request->validate([
            'selected_images' => 'required|array',
            'selected_images.*' => 'exists:question_images,image_id',
        ]);

        // Primero, desmarcar todas como no correctas
        QuestionImage::where('question_id', $questionId)->update(['is_correct' => false]);

        // Marcar solo las seleccionadas como correctas
        QuestionImage::where('question_id', $questionId)
            ->whereIn('image_id', $request->selected_images)
            ->update(['is_correct' => true]);

        return response()->json(['success' => true, 'message' => 'Respuestas correctas guardadas.']);
    }

    }
        // Si el tipo de actividad no coincide con ninguno de los anteriores
        return response()->json(['success' => false, 'message' => 'La actividad que intentas realizar no existe.']);
    }
    public function selectConfigurationMode($folder = 'pareoyseleccion')
{
    return view('manual1.select-configuration-mode', compact('folder'));
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
public function editQuestion($id)
{
    $question = Question::with('images')->findOrFail($id);
    $folder = $question->type;
    $mode = $question->mode;

    // Obtener todas las imágenes disponibles en la carpeta
    $images = Image::where('path', 'like', 'images/' . $folder . '/%')->get();

    return view('manual1.select-correct-images2', compact('question', 'images', 'folder', 'mode'));
}
public function indexQuestions()
{
    $questions = Question::with('images')->paginate(10); // Listar preguntas con paginación
    return view('manual1.questions.index', compact('questions'));
}
public function updateQuestion(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'selected_images' => 'required|array',
        'selected_images.*' => 'exists:images,id',
    ]);

    $question = Question::findOrFail($id);
    $question->update([
        'title' => $request->input('title'),
        'type' => $request->input('folder'),
        'mode' => $request->input('mode'),
    ]);

    // Actualizar las imágenes asociadas
    QuestionImage::where('question_id', $id)->delete();
    foreach ($request->selected_images as $imageId) {
        QuestionImage::create([
            'question_id' => $question->id,
            'image_id' => $imageId,
            'is_correct' => false,
        ]);
    }

    return redirect()->route('professor.questions.index')->with('message', 'Pregunta actualizada correctamente.');
}
public function deleteQuestion($id)
{
    $question = Question::findOrFail($id);
    $question->delete();

    return redirect()->route('professor.questions.index')->with('message', 'Pregunta eliminada correctamente.');
}
}



