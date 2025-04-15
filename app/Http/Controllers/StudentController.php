<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\StudentAnswer;
use App\Models\QuestionImage;

class StudentController extends Controller
{
    // Mostrar la primera pregunta no respondida por el estudiante
    public function getFirstUnansweredQuestion($type)
    {
        $studentId = auth()->id(); // Obtener el ID del estudiante autenticado

        // Obtener el ID de las preguntas que el estudiante ya respondió
        $answeredQuestions = StudentAnswer::where('student_id', $studentId)
            ->pluck('question_id')
            ->toArray();

        // Obtener la primera pregunta no respondida del tipo especificado
        $question = Question::where('type', $type) // Filtrar por tipo
            ->whereNotIn('id', $answeredQuestions)
            ->with('images.image') // Cargar las imágenes asociadas
            ->first();

        if (!$question) {
            // Si no hay preguntas sin responder, redirigir con un mensaje
            return redirect()->back()->with('message', 'No hay preguntas disponibles para esta actividad.');
        }

        // Retornar la vista con la primera pregunta no respondida
        return view('manual1.student-answer', compact('question'));
    }

    // Mostrar la pregunta al estudiante
    public function showQuestion($questionId)
    {
        $question = Question::with('images.image')->findOrFail($questionId);

        return view('manual1.student-answer', compact('question'));
    }

    // Guardar la respuesta del estudiante
    public function saveAnswer(Request $request, $questionId)
{
    $request->validate([
        'selected_images' => 'required|array', // Validar que se seleccionen imágenes
        'selected_images.*' => 'exists:question_images,image_id', // Validar que las imágenes existan en la tabla question_images
    ]);

    $studentId = auth()->id(); // Obtener el ID del estudiante autenticado

    // Obtener las imágenes correctas de la pregunta
    $correctImages = QuestionImage::where('question_id', $questionId)
        ->where('is_correct', true)
        ->pluck('image_id')
        ->toArray();

    // Comparar las respuestas del estudiante con las correctas
    $studentAnswers = $request->selected_images;
    $isCorrect = empty(array_diff($correctImages, $studentAnswers)) && empty(array_diff($studentAnswers, $correctImages));

    // Guardar las respuestas del estudiante
    foreach ($studentAnswers as $imageId) {
        StudentAnswer::create([
            'student_id' => $studentId,
            'question_id' => $questionId,
            'image_id' => $imageId,
            'is_correct' => in_array($imageId, $correctImages),
        ]);
    }

    // Obtener el tipo de la pregunta para redirigir al mismo tipo
    $type = Question::find($questionId)->type;

    // Redirigir con un mensaje
    return redirect()->route('student.answer', ['type' => $type])
        ->with('message', $isCorrect ? '¡Respuesta correcta!' : 'Respuesta incorrecta');
}
}
