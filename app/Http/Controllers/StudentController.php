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

        // Cargar la vista correspondiente según el tipo de pregunta
        if ($question->type === 'pareoyseleccion') {
            return view('manual1.student-answer-pareo', compact('question'));
        } elseif ($question->type === 'asociacion') {
            return view('manual1.student-answer-asociacion', compact('question'));
        }

        return back()->with('message', 'Tipo de actividad no reconocida.');
    }

    // Mostrar la pregunta al estudiante
    public function showQuestion($questionId)
    {
        $question = Question::with('images.image')->findOrFail($questionId);

        if ($question->type === 'pareoyseleccion') {
            return view('manual1.student-answer-pareo', compact('question'));
        } elseif ($question->type === 'asociacion') {
            return view('manual1.student-answer-asociacion', compact('question'));
        }

        return back()->with('message', 'Tipo de actividad no reconocido.');
    }

    // Guardar la respuesta del estudiante
    public function saveAnswer(Request $request, $questionId)
    {
        $studentId = auth()->id(); // Obtener el ID del estudiante autenticado

        // Obtener la pregunta y su tipo
        $question = Question::with('images')->findOrFail($questionId);

        if ($question->type === 'asociacion') {
            // Lógica para asociación (sin cambios)
            $request->validate([
                'selected_images' => 'required|array|size:2', // Validar que se seleccionen exactamente 2 imágenes
                'selected_images.*' => 'exists:question_images,image_id', // Validar que las imágenes existan
            ]);

            $selectedImages = $request->selected_images;
            $key = $selectedImages[0];
            $value = $selectedImages[1];

            // Verificar si el par es correcto (basado en el pair_id)
            $keyPairId = QuestionImage::where('question_id', $questionId)
                ->where('image_id', $key)
                ->value('pair_id');

            $valuePairId = QuestionImage::where('question_id', $questionId)
                ->where('image_id', $value)
                ->value('pair_id');

            $pairIsCorrect = ($keyPairId !== null && $keyPairId === $valuePairId);

            // Guardar cada imagen como respuesta del estudiante
            StudentAnswer::create([
                'student_id' => $studentId,
                'question_id' => $questionId,
                'image_id' => $key,
                'is_correct' => $pairIsCorrect,
            ]);

            StudentAnswer::create([
                'student_id' => $studentId,
                'question_id' => $questionId,
                'image_id' => $value,
                'is_correct' => $pairIsCorrect,
            ]);

            // Marcar las imágenes como respondidas (sin eliminarlas)
            QuestionImage::where('question_id', $questionId)
                ->whereIn('image_id', [$key, $value])
                ->update(['is_answered' => true]);

            // Verificar si quedan imágenes sin responder en la pregunta
            $remainingImages = QuestionImage::where('question_id', $questionId)
                ->where('is_answered', false)
                ->count();

            if ($remainingImages === 0) {
                // Obtener el tipo de la pregunta para redirigir al mismo tipo
                $type = $question->type;

                // Verificar si hay más preguntas sin responder
                $nextQuestion = Question::where('type', $type)
                    ->whereNotIn('id', StudentAnswer::where('student_id', $studentId)->pluck('question_id')->toArray())
                    ->first();

                if ($pairIsCorrect) {
                    if ($nextQuestion) {
                        // Redirigir a la siguiente pregunta no respondida
                        return redirect()->route('student.showQuestion', $nextQuestion->id)
                            ->with('message', '¡Respuesta correcta!');
                    } else {
                        // No hay más preguntas, redirigir a una página final
                        return redirect()->route('manual1')->with('message', '¡Has completado todas las preguntas!');
                    }
                } else {
                    if ($nextQuestion) {
                        return redirect()->route('student.showQuestion', $nextQuestion->id)
                            ->with('message', 'Respuesta incorrecta :( ');
                    } else {
                        // No hay más preguntas, redirigir a una página final
                        return redirect()->route('manual1')->with('message', '¡Has completado todas las preguntas, pero tu última respuesta fue incorrecta!');
                    }
                }
            }

            // Si quedan imágenes, recargar la misma pregunta
            return redirect()->route('student.showQuestion', $questionId)
                ->with('message', $pairIsCorrect ? '¡Par correcto!' : 'Par incorrecto. Intenta nuevamente.');
        }

        // Lógica para pareo
        if ($question->type === 'pareoyseleccion') {
            // Validar que se seleccionen imágenes
            $request->validate([
                'selected_images' => 'required|array', // Validar que se seleccionen imágenes
                'selected_images.*' => 'exists:question_images,image_id', // Validar que las imágenes existan en la tabla question_images
            ]);

            $selectedImages = $request->selected_images;

            // Obtener las imágenes correctas
            $correctImages = QuestionImage::where('question_id', $questionId)
                ->where('is_correct', true)
                ->pluck('image_id')
                ->toArray();

            $isCorrect = empty(array_diff($correctImages, $selectedImages)) && empty(array_diff($selectedImages, $correctImages));

            // Guardar las respuestas del estudiante
            foreach ($selectedImages as $imageId) {
                StudentAnswer::create([
                    'student_id' => $studentId,
                    'question_id' => $questionId,
                    'image_id' => $imageId,
                    'is_correct' => $isCorrect,
                ]);
            }

            // Marcar las imágenes como respondidas (sin eliminarlas)
            QuestionImage::where('question_id', $questionId)
                ->whereIn('image_id', $selectedImages)
                ->update(['is_answered' => true]);

            // Verificar si hay más preguntas sin responder
            $type = $question->type;
            $nextQuestion = Question::where('type', $type)
                ->whereNotIn('id', StudentAnswer::where('student_id', $studentId)->pluck('question_id')->toArray())
                ->first();

            if ($isCorrect) {
                if ($nextQuestion) {
                    // Redirigir a la siguiente pregunta no respondida
                    return redirect()->route('student.showQuestion', $nextQuestion->id)
                        ->with('message', '¡Respuesta correcta!');
                } else {
                    // No hay más preguntas, redirigir a una página final
                    return redirect()->route('manual1')->with('message', '¡Has completado todas las preguntas!');
                }
            } else {
                if ($nextQuestion) {
                    return redirect()->route('student.showQuestion', $nextQuestion->id)
                    ->with('message', 'Respuesta incorrecta :( ');
                } else {
                    // No hay más preguntas, redirigir a una página final
                    return redirect()->route('manual1')->with('message', '¡Has completado todas las preguntas, pero tu última respuesta fue incorrecta!');
                }
            }
        }
    }
}
