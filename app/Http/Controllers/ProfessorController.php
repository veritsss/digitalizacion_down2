<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Question;
use App\Models\QuestionImage;
use App\Models\StudentAnswer;
use App\Models\User;
use App\Models\LearnedWord;
use App\Models\Phrase;

class ProfessorController extends Controller
{
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

    return view('professor.monitoreo.view-student-responses', compact('student', 'responses', 'type', 'order', 'filter', 'statistics'));
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
    return view('professor.monitoreo.search-students', compact('students'));
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
        $preguntas_respondidas_ids = StudentAnswer::where('student_id', $student->id)
            ->whereIn('question_id', $question_ids)
            ->pluck('question_id')
            ->unique();

        $preguntas_respondidas = $preguntas_respondidas_ids->count();

        // Total de imágenes correctas posibles en las preguntas respondidas
        $total_correct_images = QuestionImage::whereIn('question_id', $preguntas_respondidas_ids)
            ->where('is_correct', 1)
            ->count();

        // Imágenes correctas respondidas
        $imagenes_correctas = StudentAnswer::where('student_id', $student->id)
            ->whereIn('question_id', $preguntas_respondidas_ids)
            ->where('is_correct', 1)
            ->count();

        // Imágenes incorrectas respondidas
        $imagenes_incorrectas = StudentAnswer::where('student_id', $student->id)
            ->whereIn('question_id', $preguntas_respondidas_ids)
            ->where('is_correct', 0)
            ->count();

        // Cálculo de imágenes omitidas
        $omitidas = max(0, $total_correct_images - ($imagenes_correctas + $imagenes_incorrectas));

        // Imágenes respondidas por el estudiante
        $imagenes_respondidas = $imagenes_correctas + $imagenes_incorrectas;

        if ($total_preguntas > 0) {
            $detalles[] = [
                'type' => $type,
                'total_preguntas' => $total_preguntas,
                'preguntas_respondidas' => $preguntas_respondidas,
                'total_imagenes' => $total_correct_images,
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

    return view('professor.monitoreo.student-detail', compact('student', 'detalles'));

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

    return view('professor.monitoreo.list', compact('questions'));
}
public function searchAbecedario(Request $request)
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
    return view('professor.monitoreo.search-abecedario', compact('students'));
}
public function abecedario($studentId)
{
    $student = User::findOrFail($studentId);

    // Aquí puedes cargar los datos necesarios para la vista del abecedario
    return view('professor.monitoreo.abecedario', compact('student'));
}
public function saveLearnedWords(Request $request, $studentId)
{
    $request->validate([
        'letter' => 'required|string|max:1',
        'words' => 'required|array',
        'words.*' => 'string|max:255',
    ]);

    foreach ($request->input('words') as $word) {
        LearnedWord::create([
            'student_id' => $studentId,
            'letter' => strtoupper($request->input('letter')),
            'word' => $word,
        ]);
    }

    return redirect()->back()->with('message', 'Palabras guardadas correctamente.');
}
public function deleteLearnedWord($wordId)
{
    $word = LearnedWord::findOrFail($wordId);
    $word->delete();

    return redirect()->back()->with('message', 'Palabra eliminada correctamente.');
}
public function searchImages(Request $request)
{
    $search = $request->input('search');

    // Filtrar imágenes por los valores específicos en el campo path
    $images = Image::where(function ($query) use ($search) {
        $query->where('path', 'like', "%images/unir%")
              ->orWhere('path', 'like', "%images/seleccionyasociacion%")
              ->orWhere('path', 'like', "%images/tarjetas-foto%");
    })
    ->where('path', 'like', "%$search%") // Filtrar por el término de búsqueda
    ->get();

    return response()->json($images);
}
public function createPhrase(Request $request)
{
    try {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'image_id' => 'required|exists:images,id',
            'word' => 'required|string|max:255',
            'phrase' => 'required|string|max:255',
        ]);

        // Guardar la frase en la base de datos
        Phrase::create([
            'student_id' => $request->input('student_id'),
            'image_id' => $request->input('image_id'),
            'word' => $request->input('word'),
            'phrase' => $request->input('phrase'),
        ]);

        return redirect()->back()->with([
            'message' => 'Frase creada correctamente.',
            'alert-type' => 'success',
        ]);
    } catch (\Exception $e) {
        return redirect()->back()->with([
            'message' => 'Hubo un error al crear la frase. Por favor, inténtalo nuevamente.',
            'alert-type' => 'error',
        ]);
    }
}
public function searchFrases(Request $request)
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
    return view('professor.monitoreo.search-frases', compact('students'));
}
public function showPhrases($studentId)
{
    $student = User::findOrFail($studentId);

    // Obtener las frases asociadas al estudiante
    $phrases = Phrase::where('student_id', $studentId)->get();

    // Pasar las variables a la vista
    return view('professor.frases-personales', compact('student', 'phrases'));
}
public function listFrases($studentId)
{
    $student = User::findOrFail($studentId);
    $phrases = Phrase::where('student_id', $studentId)->with('image')->get();

    return view('professor.list-frases', compact('student', 'phrases'));
}
public function searchPhrases(Request $request, $studentId)
{
    $search = $request->input('search');
    $filter = $request->input('filter', 'recent'); // Filtro por defecto: Más recientes

    $query = Phrase::where('student_id', $studentId)
        ->where(function ($query) use ($search) {
            $query->where('word', 'like', "%$search%")
                  ->orWhere('phrase', 'like', "%$search%")
                  ->orWhereHas('image', function ($q) use ($search) {
                      $q->where('path', 'like', "%$search%");
                  });
        });

    // Aplicar el filtro
    switch ($filter) {
        case 'recent':
            $query->orderBy('created_at', 'desc');
            break;
        case 'oldest':
            $query->orderBy('created_at', 'asc');
            break;
        case 'alphabetical':
            $query->orderBy('word', 'asc');
            break;
        case 'reverse-alphabetical':
            $query->orderBy('word', 'desc');
            break;
    }

    $phrases = $query->with('image')->get();

    return response()->json($phrases);
}
public function viewStudentPhrases($studentId)
{
    // Verificar que el estudiante exista
    $student = User::findOrFail($studentId);

    // Obtener las frases del estudiante
    $phrases = Phrase::where('student_id', $studentId)->with('image')->get();

    return view('professor.monitoreo.list-frases2', compact('student', 'phrases'));
}
public function searchStudentPhrases(Request $request, $studentId)
{
    $search = $request->input('search');
    $filter = $request->input('filter', 'recent'); // Filtro por defecto: Más recientes

    $query = Phrase::where('student_id', $studentId)
        ->where(function ($query) use ($search) {
            $query->where('word', 'like', "%$search%")
                  ->orWhere('phrase', 'like', "%$search%")
                  ->orWhereHas('image', function ($q) use ($search) {
                      $q->where('path', 'like', "%$search%");
                  });
        });

    // Aplicar el filtro
    switch ($filter) {
        case 'recent':
            $query->orderBy('created_at', 'desc');
            break;
        case 'oldest':
            $query->orderBy('created_at', 'asc');
            break;
        case 'alphabetical':
            $query->orderBy('word', 'asc');
            break;
        case 'reverse-alphabetical':
            $query->orderBy('word', 'desc');
            break;
    }

    $phrases = $query->with('image')->get();

    return response()->json($phrases);
}
public function deletePhrase($studentId, $phraseId)
{
    $phrase = Phrase::where('id', $phraseId)->where('student_id', $studentId)->firstOrFail();

    // Eliminar la frase
    $phrase->delete();

    return redirect()->back()->with('message', 'Frase eliminada correctamente.');
}
}



