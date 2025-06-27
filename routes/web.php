<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Manual4Controller;
use App\Http\Controllers\Manual3Controller;
use App\Http\Controllers\Manual2Controller;
use App\Http\Controllers\Manual1Controller;
use App\Http\Controllers\CartelController;
use App\Http\Controllers\ProfessorE1Controller;
use App\Http\Controllers\ProfessorE2Controller;
use App\Http\Controllers\StudentControllerE2;


Route::get('/', [HomeController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
// Rutas de autenticación

// Rutas accesibles solo para profesores
Route::middleware(['auth', 'role:Profesor'])->group(function () {

});

// Rutas accesibles solo para estudiantes
Route::middleware(['auth', 'role:Estudiante'])->group(function () {

   });

   // Rutas accesibles para todos los usuarios autenticados
Route::middleware('auth')->group(function () {



    Route::get('/inicio', function () {return view('inicio');})->name('inicio');
    Route::get('/verManuales', function () {return view('manuales'); })->name('verManuales');

    //PROFESOR GENERAL
    Route::get('/professor/student/{studentId}/responses', [ProfessorController::class, 'viewStudentResponses'])->name('professor.viewStudentResponses');
    Route::get('/professor/search-students', [ProfessorController::class, 'searchStudents'])->name('professor.searchStudents');
    Route::delete('/professor/question/{id}', [ProfessorController::class, 'deleteQuestion'])->name('professor.deleteQuestion');
    Route::get('/professor/dashboard', [ProfessorController::class, 'index'])->name('professor.dashboard');
    Route::get('/professor/estudiante/{id}/detalle', [ProfessorController::class, 'detalle'])->name('professor.studentDetail');
    Route::get('/professor/questions', [ProfessorController::class, 'listQuestions'])->name('professor.questions.list');
    Route::get('/professor/search-abecedario', [ProfessorController::class, 'searchAbecedario'])->name('professor.searchAbecedario');
    Route::post('/professor/student/{id}/abecedario/save', [ProfessorController::class, 'saveLearnedWords'])->name('professor.saveLearnedWords');
    Route::get('/professor/student/{id}/abecedario', [ProfessorController::class, 'abecedario'])->name('professor.abecedario');
    Route::delete('/professor/learned-word/{id}/delete', [ProfessorController::class, 'deleteLearnedWord'])->name('professor.deleteLearnedWord');
    Route::get('/professor/search-images', [ProfessorController::class, 'searchImages'])->name('professor.searchImages');
    Route::post('/professor/create-phrase', [ProfessorController::class, 'createPhrase'])->name('professor.createPhrase');
    Route::get('/professor/frases-personales', function () {return view('professor.frases-personales');})->name('professor.frasesPersonales');
    //ETAPA 1 PROFESOR
    Route::get('/professor/e1/select-configuration-mode/{folder}', [ProfessorE1Controller::class, 'selectConfigurationModeE1'])->name('professor.selectConfigurationModeE1');
    Route::get('/professor/e1/select-question-images/{folder}/{mode}', [ProfessorE1Controller::class, 'selectQuestionImagesPageE1'])->name('professor.selectQuestionImagesPageE1');
    Route::post('/professor/e1/select-question-images', [ProfessorE1Controller::class, 'selectQuestionImagesE1'])->name('professor.selectQuestionImagesE1');
    Route::get('/professor/e1/select-correct-images/{folder}/{mode}/{questionId}', [ProfessorE1Controller::class, 'selectCorrectImagesE1'])->name('professor.selectCorrectImagesPageE1');
    Route::post('/professor/e1/save-correct-images/{folder}', [ProfessorE1Controller::class, 'saveCorrectImagesE1'])->name('professor.saveCorrectImagesE1');

    //ETAPA 2 PROFESOR
    Route::get('/professor/e2/select-configuration-mode/{folder}', [ProfessorE2Controller::class, 'selectConfigurationModeE2'])->name('professor.selectConfigurationModeE2');
    Route::get('/professor/e2/select-question-images/{folder}/{mode}', [ProfessorE2Controller::class, 'selectQuestionImagesPageE2'])->name('professor.selectQuestionImagesPageE2');
    Route::post('/professor/e2/select-question-images', [ProfessorE2Controller::class, 'selectQuestionImagesE2'])->name('professor.selectQuestionImagesE2');
    Route::get('/professor/e2/select-correct-images/{folder}/{mode}/{questionId}', [ProfessorE2Controller::class, 'selectCorrectImagesE2'])->name('professor.selectCorrectImagesPageE2');
    Route::post('/professor/e2/save-correct-images/{folder}', [ProfessorE2Controller::class, 'saveCorrectImagesE2'])->name('professor.saveCorrectImagesE2');

    //ETAPA 1
        Route::get('/manual1', [Manual1Controller::class, 'index'])->name('manual1');
        Route::get('/pareo-seleccion-dibujo', [Manual1Controller::class, 'pareoSeleccionDibujo'])->name('pareo-seleccion-dibujo');
        Route::get('/asociacion', [Manual1Controller::class, 'asociacion'])->name('asociacion');
        Route::get('/clasificacion', [Manual1Controller::class, 'clasificacion'])->name('clasificacion');
        Route::get('/clasificacionCategoria', [Manual1Controller::class, 'clasificacionCategoria'])->name('clasificacionCategoria');
        Route::get('/clasificacionHabitat', [Manual1Controller::class, 'clasificacionHabitat'])->name('clasificacionHabitat');
        Route::get('/clasificacionColor', [Manual1Controller::class, 'clasificacionColor'])->name('clasificacionColor');
        Route::get('/pareo-igualdad', [Manual1Controller::class, 'pareoIgualdad'])->name('pareo-igualdad');
        Route::get('/series', [Manual1Controller::class, 'series'])->name('series');
        Route::get('/seriesTamaño', [Manual1Controller::class, 'seriesTamaño'])->name('seriesTamaño');
        Route::get('/seriesTemporales', [Manual1Controller::class, 'seriesTemporales'])->name('seriesTemporales');
    //ETAPA 2

        Route::get('/manual2', [Manual2Controller::class, 'index'])->name('manual2');
        Route::get('/abecedario', [Manual2Controller::class, 'abecedario'])->name('abecedario');
        Route::get('/asociar', [Manual2Controller::class, 'asociar'])->name('asociar');
        Route::get('/carteles', [Manual2Controller::class, 'carteles'])->name('carteles');
        Route::get('/componer', [Manual2Controller::class, 'componer'])->name('componer');
        Route::get('/libros-personales', [Manual2Controller::class, 'librosPersonales'])->name('libros-personales');
        Route::get('/seleccion-asociacion', [Manual2Controller::class, 'seleccionAsociacion'])->name('seleccion-asociacion');
        Route::get('/tarjetas-fotos', [Manual2Controller::class, 'tarjetasFotos'])->name('tarjetas-fotos');
        Route::get('/unir', [Manual2Controller::class, 'unir'])->name('unir');


    //ETAPA 3
        Route::get('/manual3', [Manual3Controller::class, 'index'])->name('manual3');
        Route::get('/composicion-modelo', [Manual3Controller::class, 'composicionModelo'])->name('composicion-modelo');
        Route::get('/reconocimiento-silabas', [Manual3Controller::class, 'reconocimientoSilabas'])->name('reconocimiento-silabas');


    //ETAPA 4
        Route::get('/manual4', [Manual4Controller::class, 'index'])->name('manual4');
        Route::get('/completar', [Manual4Controller::class, 'completar'])->name('completar');
        Route::get('/componer-oraciones', [Manual4Controller::class, 'componerOraciones'])->name('componer-oraciones');
        Route::get('/secuenciar-textos', [Manual4Controller::class, 'secuenciarTextos'])->name('secuenciar-textos');
        Route::get('/seleccionar', [Manual4Controller::class, 'seleccionar'])->name('seleccionar');


        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // RUTAS PARA ESTUDIANTES
        Route::get('/pareo-seleccion-dibujo/student-select-images', [StudentController::class, 'showSelectionPage'])->name('student.showSelectionPage');
        Route::post('/pareo-seleccion-dibujo/check-answer', [StudentController::class, 'checkAnswer'])->name('student.checkAnswer');
        Route::get('/student/question/{question}', [StudentController::class, 'showQuestion'])->name('student.showQuestion');
        Route::get('/student/answer/{type}', [StudentController::class, 'getFirstUnansweredQuestion'])->name('student.answer');
        Route::post('/student/question/{question}/save', [StudentController::class, 'saveAnswer'])->name('student.saveAnswer');

        Route::get('/E2/pareo-seleccion-dibujo/student-select-images', [StudentControllerE2::class, 'showSelectionPageE2'])->name('student.showSelectionPageE2');
        Route::post('/E2/pareo-seleccion-dibujo/check-answer', [StudentControllerE2::class, 'checkAnswerE2'])->name('student.checkAnswerE2');
        Route::get('/E2/student/question/{question}', [StudentControllerE2::class, 'showQuestionE2'])->name('student.showQuestionE2');
        Route::get('/E2/student/answer/{type}', [StudentControllerE2::class, 'getFirstUnansweredQuestionE2'])->name('student.answerE2');
        Route::post('/E2/student/question/{question}/save', [StudentControllerE2::class, 'saveAnswerE2'])->name('student.saveAnswerE2');
    });


require __DIR__.'/auth.php';


Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::get('/associate-carteles-tarjetas', [CartelController::class, 'showAssociateForm'])->name('cartel.showAssociateForm');
Route::post('/associate-carteles-tarjetas', [CartelController::class, 'associateTarjetaFoto'])->name('cartel.associateTarjetaFoto');

// Ruta para mostrar la vista de búsqueda de estudiantes para frases
Route::get('/professor/search-frases', [ProfessorController::class, 'searchFrases'])->name('professor.searchFrases');

// Ruta para mostrar las frases personales de un estudiante específico
Route::get('/professor/student/{studentId}/frases', [ProfessorController::class, 'showPhrases'])->name('professor.showPhrases');
Route::delete('/professor/student/{student}/phrases/{phrase}', [ProfessorController::class, 'deletePhrase'])->name('professor.deletePhrase');
Route::get('/professor/student/{studentId}/list-frases', [ProfessorController::class, 'listFrases'])->name('professor.listPhrases');
Route::get('/professor/student/{studentId}/search-phrases', [ProfessorController::class, 'searchPhrases'])->name('professor.searchPhrases');
Route::get('/student/{studentId}/phrases', [ProfessorController::class, 'viewStudentPhrases'])->name('student.listPhrases');
