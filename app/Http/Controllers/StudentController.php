<?php

namespace App\Http\Controllers;
use App\Models\QuestionImage;
use Illuminate\Http\Request;
use App\Models\Image;

class StudentController extends Controller
{
    // Mostrar las imágenes seleccionadas por el profesor
    public function showSelectionPage()
{
    $images = QuestionImage::with('image')->get();

    return view('manual1.student-select-images', compact('images'));
}

public function checkAnswer(Request $request)
{
    $request->validate([
        'selected_image' => 'required|array',
        'selected_image.*' => 'exists:question_images,image_id',
    ]);

    $selectedImages = $request->selected_image;
    $correctImages = QuestionImage::where('is_correct', true)->pluck('image_id')->toArray();

    $isCorrect = count(array_intersect($selectedImages, $correctImages)) === count($correctImages)
                 && count($selectedImages) === count($correctImages);

    if ($isCorrect) {
        return redirect()->route('student.showSelectionPage')->with('message', '¡Correcto! Has seleccionado todas las imágenes correctas.');
    } else {
        return redirect()->route('student.showSelectionPage')->with('message', 'Incorrecto. Intenta de nuevo.');
    }
}
}