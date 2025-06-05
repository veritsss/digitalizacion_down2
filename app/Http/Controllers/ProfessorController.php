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

}



