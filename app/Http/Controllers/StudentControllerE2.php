<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\StudentAnswer;
use App\Models\QuestionImage;
use Illuminate\Support\Facades\Log;

class StudentControllerE2 extends Controller
{
    // Mostrar la primera pregunta no respondida por el estudiante
   public function getFirstUnansweredQuestionE2($type)
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
        session()->flash('message', 'No hay preguntas disponibles para esta actividad.');
        session()->flash('alert-type', 'info'); // Tipo de alerta (info, success, error, etc.)
        return redirect()->back();
    }

    // Cargar la vista correspondiente
    return view('student.student-answer-etapa2', compact('question'));
}

    // Mostrar la pregunta al estudiante
    public function showQuestionE2($questionId)
    {
        $question = Question::with('images.image.cartel')->findOrFail($questionId);


       if ($question->type === 'tarjetas-foto') {
           return view('student.student-answer-etapa2', compact('question'));
        }
        elseif ($question->type === 'carteles') {
            return view('student.student-answer-etapa2', compact('question'));
        }

        return back()->with('message', 'Tipo de actividad no reconocido.');
    }

    // Guardar la respuesta del estudiante
    public function saveAnswerE2(Request $request, $questionId)
    {
        $studentId = auth()->id();
        $question = Question::with(['images.image.cartel'])->findOrFail($questionId);
        $mode = $request->input('mode', $question->type);

        // --- TARJETAS-FOTO ---
        if ($mode === 'tarjetas-foto') {
            $request->validate([
                'answers' => 'required|array',
                'answers.*' => 'exists:cartels,id',
            ]);

            $isCorrect = true;

            foreach ($question->images as $image) {
                $selectedCartelId = intval($request->input("answers.{$image->image_id}"));
                $correctCartelId = isset($image->cartel_id) ? intval($image->cartel_id) : (isset($image->cartel->id) ? intval($image->cartel->id) : null);

                $isAnswerCorrect = $selectedCartelId === $correctCartelId;

                StudentAnswer::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'question_id' => $questionId,
                        'image_id' => $image->image_id,
                    ],
                    [
                        'selected_cartel_id' => $selectedCartelId,
                        'is_correct' => $isAnswerCorrect,
                        'is_answered' => true,
                    ]
                );

                if (!$isAnswerCorrect) {
                    $isCorrect = false;
                }
            }

            return redirect()->route('manual2')
                ->with('message', $isCorrect ? '¡Respuesta correcta!' : 'Algunas respuestas son incorrectas.')
                ->with('alert-type', $isCorrect ? 'success' : 'error');
        }

        // --- PAREO MIXTO (carteles y tarjetas-foto) ---
        elseif ($mode === 'pairs') {
            $request->validate([
                'selected_images' => 'required|array|size:2', // Deben seleccionarse exactamente 2 imágenes para un par
                'selected_images.*' => 'exists:question_images,image_id',
            ]);

            $selectedImages = $request->input('selected_images');
            // Obtener los pair_id de las imágenes seleccionadas
            $pairIds = QuestionImage::where('question_id', $questionId)
                ->whereIn('image_id', $selectedImages)
                ->pluck('pair_id', 'image_id')
                ->toArray();

            // Verificar si ambas imágenes pertenecen al mismo par
            $isCorrect = count(array_unique($pairIds)) === 1;

            foreach ($selectedImages as $imageId) {
                StudentAnswer::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'question_id' => $questionId,
                        'image_id' => $imageId,
                    ],
                    [
                        'pair_id' => $pairIds[$imageId] ?? null,
                        'is_correct' => $isCorrect,
                        'is_answered' => true,
                    ]
                );
            }

            // Obtener imágenes ya respondidas por el estudiante para esta pregunta
            $answeredImages = StudentAnswer::where('student_id', $studentId)
                ->where('question_id', $questionId)
                ->where('is_answered', true)
                ->pluck('image_id')
                ->toArray();

            // Verificar si quedan imágenes sin responder por el estudiante
            $remainingImages = QuestionImage::where('question_id', $questionId)
                ->whereNotIn('image_id', $answeredImages)
                ->count();

            if ($remainingImages < 2) {
                // Pasar a la siguiente pregunta si no quedan pares
                $type = $question->type;
                $answeredQuestions = StudentAnswer::where('student_id', $studentId)
                    ->pluck('question_id')
                    ->toArray();

                $nextQuestion = Question::where('type', $type)
                    ->whereNotIn('id', $answeredQuestions)
                    ->first();

                if ($nextQuestion) {
                    session()->flash('message', $isCorrect ? '¡Par correcto!' : 'Par incorrecto.');
                    session()->flash('alert-type', $isCorrect ? 'success' : 'error');
                    return redirect()->route('student.showQuestionE2', $nextQuestion->id);
                } else {
                    $finalMessage = ($isCorrect ? '¡Par correcto!' : 'Par incorrecto.') . ' ¡Has completado todas las preguntas!';
                    session()->flash('message', $finalMessage);
                    session()->flash('alert-type', $isCorrect ? 'success' : 'error');
                    return redirect()->route('manual2');
                }
            }

            // Si quedan pares, recargar la misma pregunta
            session()->flash('message', $isCorrect ? '¡Par correcto!' : 'Par incorrecto.');
            session()->flash('alert-type', $isCorrect ? 'success' : 'error');
            return redirect()->route('student.showQuestionE2', $questionId);
        }

        // --- OTROS MODOS ---
        return back()->with('message', 'Modo de actividad no reconocido.')->with('alert-type', 'error');
    }

}


