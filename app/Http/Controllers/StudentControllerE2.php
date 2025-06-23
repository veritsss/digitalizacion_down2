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
    $unir2 = collect();
    $unir = collect();
    $asociar = collect();
    $asociar2 = collect();
    $seleccion = collect();
    $seleccion2 = collect();

    if ($question->type === 'unir') {
        $unir2 = $question->images->filter(function($qi) {
            return strpos($qi->image->path, 'images/cartelesUnir/') === 0;
        })->values();

        $unir = $question->images->filter(function($qi) {
            return strpos($qi->image->path, 'images/unir/') === 0;
        })->values();
    }
    elseif ($question->type === 'asociar') {
        $asociar = $question->images->filter(function($qi) {
            return strpos($qi->image->path, 'images/asociar/') === 0;
        })->values();

        $asociar2 = $question->images->filter(function($qi) {
            return strpos($qi->image->path, 'images/cartelesAsociar/') === 0;
        })->values();
    }
    elseif ($question->type === 'seleccion') {
        $seleccion = $question->images->filter(function($qi) {
            return strpos($qi->image->path, 'images/seleccionyasociacion/') === 0;
        })->values();

        $seleccion2 = $question->images->filter(function($qi) {
            return strpos($qi->image->path, 'images/cartelesSeleccion/') === 0;
        })->values();
    }

    return view('student.student-answer-etapa2', compact('question', 'unir', 'unir2', 'asociar', 'asociar2', 'seleccion', 'seleccion2'));
}

    // Mostrar la pregunta al estudiante
    public function showQuestionE2($questionId)
{
    $studentId = auth()->id();
    $question = Question::with('images.image')->findOrFail($questionId);

    // Obtener las imágenes ya respondidas por el estudiante
    $answeredImages = StudentAnswer::where('student_id', $studentId)
        ->where('question_id', $questionId)
        ->pluck('image_id')
        ->toArray();

    // Por defecto, colecciones vacías
    $unir = collect();
    $unir2 = collect();
    $asociar = collect();
    $asociar2 = collect();
    $seleccion = collect();
    $seleccion2 = collect();

    if ($question->type === 'unir') {
        $unir = $question->images->filter(function($qi) use ($answeredImages) {
            return strpos($qi->image->path, 'images/unir/') === 0 && !in_array($qi->image_id, $answeredImages);
        })->values();

        $unir2 = $question->images->filter(function($qi) use ($answeredImages) {
            return strpos($qi->image->path, 'images/cartelesUnir/') === 0 && !in_array($qi->image_id, $answeredImages);
        })->values();
    } elseif ($question->type === 'asociar') {
        $asociar = $question->images->filter(function($qi) use ($answeredImages) {
            return strpos($qi->image->path, 'images/asociar/') === 0 && !in_array($qi->image_id, $answeredImages);
        })->values();

        $asociar2 = $question->images->filter(function($qi) use ($answeredImages) {
            return strpos($qi->image->path, 'images/cartelesAsociar/') === 0 && !in_array($qi->image_id, $answeredImages);
        })->values();
    }
    elseif ($question->type === 'seleccion') {
        $seleccion = $question->images->filter(function($qi) use ($answeredImages) {
            return strpos($qi->image->path, 'images/seleccionyasociacion/') === 0 && !in_array($qi->image_id, $answeredImages);
        })->values();

        $seleccion2 = $question->images->filter(function($qi) use ($answeredImages) {
            return strpos($qi->image->path, 'images/cartelesSeleccion/') === 0 && !in_array($qi->image_id, $answeredImages);
        })->values();
    }

    return view('student.student-answer-etapa2', compact('question', 'unir', 'unir2', 'asociar', 'asociar2', 'seleccion', 'seleccion2'));
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
              // Redirigir a la siguiente pregunta o finalizar
        $nextQuestion = Question::where('type', $question->type)
            ->whereNotIn('id', StudentAnswer::where('student_id', $studentId)->pluck('question_id')->toArray())
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
    'unir_id' => 'required|exists:question_images,image_id',
    'unir2_id' => 'required|exists:question_images,image_id',
]);

$unirId = $request->input('unir_id');
$unir2Id = $request->input('unir2_id');

$pairUnir = QuestionImage::where('question_id', $questionId)->where('image_id', $unirId)->first();
$pairUnir2 = QuestionImage::where('question_id', $questionId)->where('image_id', $unir2Id)->first();

$isPairCorrect = $pairUnir && $pairUnir2 && $pairUnir->pair_id === $pairUnir2->pair_id;

// Verificar si el pair_id aparece solo una vez en la pregunta
$pairCounts = QuestionImage::where('question_id', $questionId)
    ->whereNotNull('pair_id')
    ->pluck('pair_id')
    ->countBy();

foreach ($pairCounts as $pairId => $count) {
    if ($count === 1 && $pairId !== null) {
        QuestionImage::where('question_id', $questionId)
            ->where('pair_id', $pairId)
            ->update(['is_correct' => 0]);
    }
}

// Guardar la respuesta del estudiante para unir
StudentAnswer::updateOrCreate(
    [
        'student_id' => $studentId,
        'question_id' => $questionId,
        'image_id' => $unirId,
    ],
    [
        'pair_id' => $pairUnir->pair_id ?? null,
        'is_correct' => $isPairCorrect,
        'is_answered' => true,
    ]
);

// Guardar la respuesta del estudiante para unir2
StudentAnswer::updateOrCreate(
    [
        'student_id' => $studentId,
        'question_id' => $questionId,
        'image_id' => $unir2Id,
    ],
    [
        'pair_id' => $pairUnir2->pair_id ?? null,
        'is_correct' => $isPairCorrect,
        'is_answered' => true,
    ]
);

// Verificar si quedan imágenes de unir o unir2 sin responder
$remainingUnir = QuestionImage::where('question_id', $questionId)
    ->whereNotIn('image_id', StudentAnswer::where('student_id', $studentId)
        ->where('question_id', $questionId)
        ->pluck('image_id')
        ->toArray())
    ->whereHas('image', function ($query) {
        $query->where('path', 'LIKE', 'images/unir/%');
    })
    ->count();

$remainingUnir2 = QuestionImage::where('question_id', $questionId)
    ->whereNotIn('image_id', StudentAnswer::where('student_id', $studentId)
        ->where('question_id', $questionId)
        ->pluck('image_id')
        ->toArray())
    ->whereHas('image', function ($query) {
        $query->where('path', 'LIKE', 'images/cartelesUnir/%');
    })
    ->count();

if ($remainingUnir === 0 || $remainingUnir2 === 0) {
    // Pasar a la siguiente pregunta
    $nextQuestion = Question::where('type', $question->type)
        ->whereNotIn('id', StudentAnswer::where('student_id', $studentId)->pluck('question_id')->toArray())
        ->first();

      if ($nextQuestion) {
                    session()->flash('message', $isPairCorrect ? '¡Par correcto!' : 'Par incorrecto.');
                    session()->flash('alert-type', $isPairCorrect ? 'success' : 'error');
                    return redirect()->route('student.showQuestionE2', $nextQuestion->id);
                } else {
                    $finalMessage = ($isPairCorrect ? '¡Par correcto!' : 'Par incorrecto.') . ' ¡Has completado todas las preguntas!';
                    session()->flash('message', $finalMessage);
                    session()->flash('alert-type', $isPairCorrect ? 'success' : 'error');
                    return redirect()->route('manual2');
                }
            }

            // Si quedan pares, recargar la misma pregunta
            session()->flash('message', $isPairCorrect ? '¡Par correcto!' : 'Par incorrecto.');
            session()->flash('alert-type', $isPairCorrect ? 'success' : 'error');
            return redirect()->route('student.showQuestionE2', $questionId);
}
elseif ($mode === 'asociar') {
    $request->validate([
        'asociar_id' => 'required|exists:question_images,image_id',
        'asociar2_id' => 'required|exists:question_images,image_id',
    ]);

    $asociarId = $request->input('asociar_id');
    $asociar2Id = $request->input('asociar2_id');

    $pairAsociar = QuestionImage::where('question_id', $questionId)->where('image_id', $asociarId)->first();
    $pairAsociar2 = QuestionImage::where('question_id', $questionId)->where('image_id', $asociar2Id)->first();

    $isPairCorrect = $pairAsociar && $pairAsociar2 && $pairAsociar->pair_id === $pairAsociar2->pair_id;

    // Guardar la respuesta del estudiante para asociar
    StudentAnswer::updateOrCreate(
        [
            'student_id' => $studentId,
            'question_id' => $questionId,
            'image_id' => $asociarId,
        ],
        [
            'pair_id' => $pairAsociar->pair_id ?? null,
            'is_correct' => $isPairCorrect,
            'is_answered' => true,
        ]
    );

    // Guardar la respuesta del estudiante para asociar2
    StudentAnswer::updateOrCreate(
        [
            'student_id' => $studentId,
            'question_id' => $questionId,
            'image_id' => $asociar2Id,
        ],
        [
            'pair_id' => $pairAsociar2->pair_id ?? null,
            'is_correct' => $isPairCorrect,
            'is_answered' => true,
        ]
    );

    // Verificar si quedan imágenes de asociar o asociar2 sin responder
    $remainingAsociar = QuestionImage::where('question_id', $questionId)
        ->whereNotIn('image_id', StudentAnswer::where('student_id', $studentId)
            ->where('question_id', $questionId)
            ->pluck('image_id')
            ->toArray())
        ->whereHas('image', function ($query) {
            $query->where('path', 'LIKE', 'images/asociar/%');
        })
        ->count();

    $remainingAsociar2 = QuestionImage::where('question_id', $questionId)
        ->whereNotIn('image_id', StudentAnswer::where('student_id', $studentId)
            ->where('question_id', $questionId)
            ->pluck('image_id')
            ->toArray())
        ->whereHas('image', function ($query) {
            $query->where('path', 'LIKE', 'images/cartelesAsociar/%');
        })
        ->count();

    if ($remainingAsociar === 0 || $remainingAsociar2 === 0) {
        // Pasar a la siguiente pregunta
        $nextQuestion = Question::where('type', $question->type)
            ->whereNotIn('id', StudentAnswer::where('student_id', $studentId)->pluck('question_id')->toArray())
            ->first();

       if ($nextQuestion) {
                    session()->flash('message', $isPairCorrect ? '¡Par correcto!' : 'Par incorrecto.');
                    session()->flash('alert-type', $isPairCorrect ? 'success' : 'error');
                    return redirect()->route('student.showQuestionE2', $nextQuestion->id);
                } else {
                    $finalMessage = ($isPairCorrect ? '¡Par correcto!' : 'Par incorrecto.') . ' ¡Has completado todas las preguntas!';
                    session()->flash('message', $finalMessage);
                    session()->flash('alert-type', $isPairCorrect ? 'success' : 'error');
                    return redirect()->route('manual2');
                }
            }

            // Si quedan pares, recargar la misma pregunta
            session()->flash('message', $isPairCorrect ? '¡Par correcto!' : 'Par incorrecto.');
            session()->flash('alert-type', $isPairCorrect ? 'success' : 'error');
            return redirect()->route('student.showQuestionE2', $questionId);
}
elseif ($mode === 'seleccionyasociacion') {
    $request->validate([
        'seleccion_id' => 'required|exists:question_images,image_id',
        'seleccion2_id' => 'required|exists:question_images,image_id',
    ]);
    $seleccionId = $request->input('seleccion_id');
    $seleccion2Id = $request->input('seleccion2_id');
    $pairSeleccion = QuestionImage::where('question_id', $questionId)->where('image_id', $seleccionId)->first();
    $pairSeleccion2 = QuestionImage::where('question_id', $questionId)->where('image_id', $seleccion2Id)->first();
    $isPairCorrect = $pairSeleccion && $pairSeleccion2 && $pairSeleccion->pair_id === $pairSeleccion2->pair_id;
    // Guardar la respuesta del estudiante para seleccion
    StudentAnswer::updateOrCreate(
        [
            'student_id' => $studentId,
            'question_id' => $questionId,
            'image_id' => $seleccionId,
        ],
        [
            'pair_id' => $pairSeleccion->pair_id ?? null,
            'is_correct' => $isPairCorrect,
            'is_answered' => true,
        ]
    );
    // Guardar la respuesta del estudiante para seleccion2
    StudentAnswer::updateOrCreate(
        [
            'student_id' => $studentId,
            'question_id' => $questionId,
            'image_id' => $seleccion2Id,
        ],
        [
            'pair_id' => $pairSeleccion2->pair_id ?? null,
            'is_correct' => $isPairCorrect,
            'is_answered' => true,
        ]
    );
    // Verificar si quedan imágenes de seleccion o seleccion2 sin responder
    $remainingSeleccion = QuestionImage::where('question_id', $questionId)
        ->whereNotIn('image_id', StudentAnswer::where('student_id', $studentId)
            ->where('question_id', $questionId)
            ->pluck('image_id')
            ->toArray())
        ->whereHas('image', function ($query) {
            $query->where('path', 'LIKE', 'images/seleccionyasociacion/%');
        })
        ->count();
    $remainingSeleccion2 = QuestionImage::where('question_id', $questionId)
        ->whereNotIn('image_id', StudentAnswer::where('student_id', $studentId)
            ->where('question_id', $questionId)
            ->pluck('image_id')
            ->toArray())
        ->whereHas('image', function ($query) {
            $query->where('path', 'LIKE', 'images/cartelesSeleccion/%');
        })
        ->count();
    if ($remainingSeleccion === 0 || $remainingSeleccion2 === 0) {
        // Pasar a la siguiente pregunta
        $nextQuestion = Question::where('type', $question->type)
            ->whereNotIn('id', StudentAnswer::where('student_id', $studentId)->pluck('question_id')->toArray())
            ->first();
       if ($nextQuestion) {
                    session()->flash('message', $isPairCorrect ? '¡Par correcto!' : 'Par incorrecto.');
                    session()->flash('alert-type', $isPairCorrect ? 'success' : 'error');
                    return redirect()->route('student.showQuestionE2', $nextQuestion->id);
                } else {
                    $finalMessage = ($isPairCorrect ? '¡Par correcto!' : 'Par incorrecto.') . ' ¡Has completado todas las preguntas!';
                    session()->flash('message', $finalMessage);
                    session()->flash('alert-type', $isPairCorrect ? 'success' : 'error');
                    return redirect()->route('manual2');
                }
            }

            // Si quedan pares, recargar la misma pregunta
            session()->flash('message', $isPairCorrect ? '¡Par correcto!' : 'Par incorrecto.');
            session()->flash('alert-type', $isPairCorrect ? 'success' : 'error');
            return redirect()->route('student.showQuestionE2', $questionId);
}

        // --- OTROS MODOS ---
        return back()->with('message', 'Modo de actividad no reconocido.')->with('alert-type', 'error');
    }

}


