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
    $studentId = auth()->id();

    $answeredQuestions = StudentAnswer::where('student_id', $studentId)
        ->pluck('question_id')
        ->toArray();

    $question = Question::where('type', $type)
        ->whereNotIn('id', $answeredQuestions)
        ->with('images.image.cartel')
        ->first();

    if (!$question) {
        session()->flash('message', 'No hay preguntas disponibles para esta actividad.');
        session()->flash('alert-type', 'info');
        return redirect()->back();
    }

    // --- SEPARAR CARTELS Y TARJETAS SI ES UNIR ---
    $cartels = collect();
    $tarjetas = collect();

    if ($question->type === 'unir') {
        $cartels = $question->images->filter(function($qi) {
            return strpos($qi->image->path, 'images/carteles/') === 0;
        })->values();

        $tarjetas = $question->images->filter(function($qi) {
            return strpos($qi->image->path, 'images/tarjetas-foto/') === 0;
        })->values();
    }

    return view('student.student-answer-etapa2', compact('question', 'cartels', 'tarjetas'));
}

    // Mostrar la pregunta al estudiante
    public function showQuestionE2($questionId)
    {
        $question = Question::with('images.image.cartel')->findOrFail($questionId);

        // Por defecto, colecciones vacías
        $cartels = collect();
        $tarjetas = collect();

        if ($question->type === 'unir') {
            // Separa carteles e imágenes según el path
            $cartels = $question->images->filter(function($qi) {
                return strpos($qi->image->path, 'images/carteles/') === 0;
            })->values();

            $tarjetas = $question->images->filter(function($qi) {
                return strpos($qi->image->path, 'images/tarjetas-foto/') === 0;
            })->values();
        }

        return view('student.student-answer-etapa2', compact('question', 'cartels', 'tarjetas'));
    }

    // Guardar la respuesta del estudiante
    public function saveAnswerE2(Request $request, $questionId)
    {
        $studentId = auth()->id();
        $question = Question::with(['images.image.cartel'])->findOrFail($questionId);
        $mode = $request->input('mode');

        // --- TARJETAS-FOTO ---
        if ($mode === 'tarjetas-foto') {
            $request->validate([
                'answers' => 'required|array',
                'answers.*' => 'exists:carteles,id',
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
        elseif ($mode === 'unir') {
    $request->validate([
        'cartel_ids' => 'required|array',
        'selected_images' => 'required|array',
        'cartel_ids.*' => 'exists:question_images,image_id',
        'selected_images.*' => 'exists:question_images,image_id',
    ]);

    $cartelIds = $request->input('cartel_ids');
    $selectedImages = $request->input('selected_images');

    $pareadosCarteles = [];
    $pareadosTarjetas = [];

    // 1. Obtener todos los pair_id de la pregunta y contar cuántas veces aparece cada uno
    $pairCounts = QuestionImage::where('question_id', $questionId)
        ->whereNotNull('pair_id')
        ->pluck('pair_id')
        ->countBy();

    // 2. Si un pair_id aparece solo una vez, actualizar is_correct a 0 en question_images
    foreach ($pairCounts as $pairId => $count) {
        if ($count === 1 && $pairId !== null) {
            QuestionImage::where('question_id', $questionId)
                ->where('pair_id', $pairId)
                ->update(['is_correct' => 0]);
        }
    }

    // Marcar pares seleccionados
    for ($i = 0; $i < max(count($cartelIds), count($selectedImages)); $i++) {
        $cartelId = $cartelIds[$i] ?? null;
        $tarjetaId = $selectedImages[$i] ?? null;

        if (!$cartelId || !$tarjetaId) {
            if ($cartelId) {
                StudentAnswer::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'question_id' => $questionId,
                        'image_id' => $cartelId,
                    ],
                    [
                        'pair_id' => null,
                        'is_correct' => false,
                        'is_answered' => true,
                    ]
                );
            }
            if ($tarjetaId) {
                StudentAnswer::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'question_id' => $questionId,
                        'image_id' => $tarjetaId,
                    ],
                    [
                        'pair_id' => null,
                        'is_correct' => false,
                        'is_answered' => true,
                    ]
                );
            }
            continue;
        }

        $pairCartel = QuestionImage::where('question_id', $questionId)->where('image_id', $cartelId)->first();
        $pairTarjeta = QuestionImage::where('question_id', $questionId)->where('image_id', $tarjetaId)->first();

        // Si el pair_id está solo (aparece solo una vez), es incorrecto
        $isPairCorrect = false;
        if ($pairCartel && $pairTarjeta && $pairCartel->pair_id === $pairTarjeta->pair_id && $pairCartel->pair_id !== null) {
            $pairId = $pairCartel->pair_id;
            $isPairCorrect = ($pairCounts[$pairId] ?? 0) > 1;
        }

        StudentAnswer::updateOrCreate(
            [
                'student_id' => $studentId,
                'question_id' => $questionId,
                'image_id' => $cartelId,
            ],
            [
                'pair_id' => $pairCartel->pair_id ?? null,
                'is_correct' => $isPairCorrect,
                'is_answered' => true,
            ]
        );
        StudentAnswer::updateOrCreate(
            [
                'student_id' => $studentId,
                'question_id' => $questionId,
                'image_id' => $tarjetaId,
            ],
            [
                'pair_id' => $pairTarjeta->pair_id ?? null,
                'is_correct' => $isPairCorrect,
                'is_answered' => true,
            ]
        );

        $pareadosCarteles[] = $cartelId;
        $pareadosTarjetas[] = $tarjetaId;
    }

    // Marcar como incorrectos los carteles sin pareja
    $allCarteles = QuestionImage::where('question_id', $questionId)
        ->whereIn('image_id', $cartelIds)
        ->pluck('image_id')
        ->toArray();

    foreach ($allCarteles as $cartelId) {
        if (!in_array($cartelId, $pareadosCarteles)) {
            StudentAnswer::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'question_id' => $questionId,
                    'image_id' => $cartelId,
                ],
                [
                    'pair_id' => null,
                    'is_correct' => false,
                    'is_answered' => true,
                ]
            );
        }
    }

    // Marcar como incorrectos las tarjetas sin pareja
    $allTarjetas = QuestionImage::where('question_id', $questionId)
        ->whereIn('image_id', $selectedImages)
        ->pluck('image_id')
        ->toArray();

    foreach ($allTarjetas as $tarjetaId) {
        if (!in_array($tarjetaId, $pareadosTarjetas)) {
            StudentAnswer::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'question_id' => $questionId,
                    'image_id' => $tarjetaId,
                ],
                [
                    'pair_id' => null,
                    'is_correct' => false,
                    'is_answered' => true,
                ]
            );
        }
    }

    return redirect()->route('manual2')
        ->with('message', '¡Respuestas guardadas!')
        ->with('alert-type', 'success');
}

        // --- OTROS MODOS ---
        return back()->with('message', 'Modo de actividad no reconocido.')->with('alert-type', 'error');
    }

}


