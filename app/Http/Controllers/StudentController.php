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
        session()->flash('message', 'No hay preguntas disponibles para esta actividad.');
        session()->flash('alert-type', 'info'); // Tipo de alerta (info, success, error, etc.)
        return redirect()->back();
    }

    // Cargar la vista correspondiente
    return view('manual1.student-answer-pareo', compact('question'));
}

    // Mostrar la pregunta al estudiante
    public function showQuestion($questionId)
    {
        $question = Question::with('images.image.cartel')->findOrFail($questionId);


        if ($question->type === 'pareoyseleccion') {
            return view('manual1.student-answer-pareo', compact('question'));
        } elseif ($question->type === 'asociacion') {
            return view('manual1.student-answer-pareo', compact('question'));
        }
        elseif ($question->type === 'clasificacionColor') {
            return view('manual1.student-answer-pareo', compact('question'));
        }
        elseif ($question->type === 'clasificacionCategoria') {
            return view('manual1.student-answer-pareo', compact('question'));
        }
        elseif ($question->type === 'clasificacionHabitat') {
            return view('manual1.student-answer-pareo', compact('question'));
        }
        elseif ($question->type === 'seriesTemporales') {
            return view('manual1.student-answer-pareo', compact('question'));
        }
        elseif ($question->type === 'seriesTamaño') {
            return view('manual1.student-answer-pareo', compact('question'));
        }
        elseif ($question->type === 'pareoporigualdad') {
            return view('manual1.student-answer-pareo', compact('question'));
        }
        elseif ($question->type === 'tarjetas-foto') {
            return view('manual1.student-answer-pareo', compact('question'));
        }

        return back()->with('message', 'Tipo de actividad no reconocido.');
    }

    // Guardar la respuesta del estudiante
    public function saveAnswer(Request $request, $questionId)
    {
        $studentId = auth()->id(); // Obtener el ID del estudiante autenticado
        $question = Question::with('images')->findOrFail($questionId);
        $mode = $request->input('mode'); // Obtener el modo desde el formulario

        if ($mode === 'images') {
            // Validar las imágenes seleccionadas
            $request->validate([
                'selected_images' => 'required|array',
                'selected_images.*' => 'exists:question_images,image_id',
            ]);

            $selectedImages = $request->input('selected_images');
            $correctImages = QuestionImage::where('question_id', $questionId)
                ->where('is_correct', true)
                ->pluck('image_id')
                ->toArray();



            // Guardar las respuestas del estudiante
            foreach ($selectedImages as $imageId) {
    $isCorrect = in_array($imageId, $correctImages);
    StudentAnswer::create([
        'student_id' => $studentId,
        'question_id' => $questionId,
        'image_id' => $imageId,
        'is_correct' => $isCorrect,
    ]);
}

// Marcar las imágenes como respondidas
QuestionImage::where('question_id', $questionId)
    ->whereIn('image_id', $selectedImages)
    ->update(['is_answered' => true]);

// Verificar si hay más preguntas sin responder
$nextQuestion = Question::where('type', $question->type)
    ->whereNotIn('id', StudentAnswer::where('student_id', $studentId)->pluck('question_id')->toArray())
    ->first();

if ($nextQuestion) {
    session()->flash('message', $isCorrect ? '¡Respuesta correcta!' : 'Respuesta incorrecta.');
    session()->flash('alert-type', $isCorrect ? 'success' : 'error'); // Tipo de alerta basado en la respuesta
    return redirect()->route('student.showQuestion', $nextQuestion->id);
}else {
    $finalMessage = ($isCorrect ? '¡Respuesta correcta!' : 'Respuesta incorrecta.') . ' ¡Has completado todas las preguntas!';
    session()->flash('message', $finalMessage);
    session()->flash('alert-type', $isCorrect ? 'success' : 'error'); // Tipo de alerta basado en la última respuesta
    return redirect()->route('manual1');
}
        } elseif ($mode === 'pairs') {
            // Validar las imágenes seleccionadas
            $request->validate([
                'selected_images' => 'required|array', // Validar que se seleccionen imágenes
                'selected_images.*' => 'exists:question_images,image_id', // Validar que las imágenes existan
            ]);

            $selectedImages = $request->input('selected_images');
            $pairs = []; // Almacenar los pares seleccionados

            // Agrupar las imágenes seleccionadas en pares
            foreach ($selectedImages as $imageId) {
                $pairId = QuestionImage::where('question_id', $questionId)
                    ->where('image_id', $imageId)
                    ->value('pair_id');

                if ($pairId !== null) {
                    $pairs[$pairId][] = $imageId;
                }
            }

            $isCorrect = true; // Inicialmente asumimos que la respuesta es correcta

            foreach ($pairs as $pairId => $images) {
                if (count($images) < 2) {
                    $isCorrect = false; // Si un par no tiene exactamente 2 imágenes, es incorrecto
                }

                // Guardar cada imagen como respuesta del estudiante
                foreach ($images as $imageId) {
                    StudentAnswer::create([
                        'student_id' => $studentId,
                        'question_id' => $questionId,
                        'image_id' => $imageId,
                        'pair_id' => $pairId,
                        'is_correct' => $isCorrect,
                    ]);

                    // Marcar la imagen como respondida
                    QuestionImage::where('question_id', $questionId)
                        ->where('image_id', $imageId)
                        ->update(['is_answered' => true]);
                }
            }

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

                if ($nextQuestion) {
                    session()->flash('message', $isCorrect ? '¡Respuesta correcta!' : 'Respuesta incorrecta.');
                    session()->flash('alert-type', $isCorrect ? 'success' : 'error'); // Tipo de alerta basado en la respuesta
                    return redirect()->route('student.showQuestion', $nextQuestion->id);
                } else {
                    $finalMessage = ($isCorrect ? '¡Respuesta correcta!' : 'Respuesta incorrecta.') . ' ¡Has completado todas las preguntas!';
                    session()->flash('message', $finalMessage);
                    session()->flash('alert-type', $isCorrect ? 'success' : 'error'); // Tipo de alerta basado en la última respuesta
                    return redirect()->route('manual1');
                }
            }

            // Si quedan imágenes, recargar la misma pregunta

            session()->flash('message', $isCorrect ? '¡Respuesta correcta!' : 'Respuesta incorrecta.');
            session()->flash('alert-type', $isCorrect ? 'success' : 'error');
            return redirect()->route('student.showQuestion', $questionId);

        } elseif ($question->type === 'seriesTemporales') {
            // Validar que se envíen respuestas para cada grupo
            $request->validate([
                'respuesta' => 'required|array',
            ]);

            $series = [];
            foreach ($request->input('respuesta') as $group => $imagenes) {
                // Ordenar por el valor ingresado por el estudiante (el orden que seleccionó)
                $ordenEstudiante = collect($imagenes)->sortBy(fn($orden) => $orden)->keys()->toArray();

                // Obtener el orden correcto desde la base de datos
                $ordenCorrecto = $question->images
                    ->where('image.sequence_group', $group)
                    ->sortBy('image.sequence_order')
                    ->pluck('image_id')
                    ->toArray();

                // Guardar la respuesta del estudiante
                foreach ($imagenes as $imageId => $ordenSeleccionado) {
                    StudentAnswer::create([
                        'student_id' => $studentId,
                        'question_id' => $questionId,
                        'image_id' => $imageId,
                        'sequence_group' => $group,
                        'selected_order' => $ordenSeleccionado,
                        'is_correct' => ($ordenCorrecto[$ordenSeleccionado - 1] ?? null) == $imageId,
                    ]);
                }

                // Validar si la secuencia es correcta
                if ($ordenEstudiante !== $ordenCorrecto) {
                    $isCorrect = false;
                }
            }

           return redirect()->route('manual1')
            ->with('message', '¡Respuesta enviada!')
            ->with('alert-type', 'success');

        }
    elseif ($question->type === 'tarjetas-foto') {
    // Validar las respuestas enviadas
    $request->validate([
        'answers' => 'required|array',
        'answers.*' => 'exists:cartels,id', // Validar que los IDs de los carteles existan
    ]);

    $isCorrect = true;

    foreach ($question->images as $image) {
        $selectedCartelId = intval($request->input("answers.{$image->image_id}")); // ID seleccionado por el estudiante
        $correctCartelId = intval($image->cartel_id); // ID correcto desde la tabla `images`

        $isAnswerCorrect = $selectedCartelId === $correctCartelId; // Comparar como enteros

        logger("Imagen ID: {$image->image_id}, Cartel Seleccionado: {$selectedCartelId}, Cartel Correcto: {$correctCartelId}, Resultado: " . ($isAnswerCorrect ? 'Correcto' : 'Incorrecto'));

        // Guardar la respuesta del estudiante
        StudentAnswer::create([
            'student_id' => $studentId,
            'question_id' => $questionId,
            'image_id' => $image->image_id,
            'selected_cartel_id' => $selectedCartelId,
            'is_correct' => $isAnswerCorrect,
        ]);

        // Si alguna respuesta es incorrecta, marcar la pregunta como incorrecta
        if (!$isAnswerCorrect) {
            $isCorrect = false;
        }
    }

    // Redirigir con un mensaje de éxito o error
    return redirect()->route('manual1')
        ->with('message', $isCorrect ? '¡Respuesta correcta!' : 'Algunas respuestas son incorrectas.')
        ->with('alert-type', $isCorrect ? 'success' : 'error');
}
    }

}

