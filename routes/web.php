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


Route::get('/', function () {
    return view('welcome');
});



// Rutas accesibles solo para profesores
Route::middleware(['auth', 'role:Profesor'])->group(function () {

});

// Rutas accesibles solo para estudiantes
Route::middleware(['auth', 'role:Estudiante'])->group(function () {

   });

   // Rutas accesibles para todos los usuarios autenticados
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/inicio', function () {
        return view('inicio');
    })->name('inicio');


    Route::get('/professor/dashboard', [ProfessorController::class, 'index'])->name('professor.dashboard');
    Route::get('/professor/estudiante/{id}/detalle', [ProfessorController::class, 'detalle'])->name('professor.studentDetail');


    Route::get('/professor/select-configuration-mode/{folder}', [ProfessorController::class, 'selectConfigurationMode'])->name('professor.selectConfigurationMode');
    Route::get('/professor/select-question-images/{folder}/{mode}', [ProfessorController::class, 'selectQuestionImagesPage'])->name('professor.selectQuestionImagesPage');
    Route::post('/professor/select-question-images', [ProfessorController::class, 'selectQuestionImages'])->name('professor.selectQuestionImages');
    Route::get('/professor/select-correct-images/{folder}/{mode}/{questionId}', [ProfessorController::class, 'selectCorrectImages'])->name('professor.selectCorrectImagesPage');
    Route::post('/professor/save-correct-images/{folder}', [ProfessorController::class, 'saveCorrectImages'])->name('professor.saveCorrectImages');
    Route::get('/professor/student/{studentId}/responses', [ProfessorController::class, 'viewStudentResponses'])->name('professor.viewStudentResponses');
    Route::get('/professor/search-students', [ProfessorController::class, 'searchStudents'])->name('professor.searchStudents');

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

        Route::get('/pareo-seleccion-dibujo/student-select-images', [StudentController::class, 'showSelectionPage'])->name('student.showSelectionPage');
    Route::post('/pareo-seleccion-dibujo/check-answer', [StudentController::class, 'checkAnswer'])->name('student.checkAnswer');

    // Mostrar la pregunta al estudiante
    Route::get('/student/question/{question}', [StudentController::class, 'showQuestion'])->name('student.showQuestion');
    Route::delete('/professor/question/{id}', [ProfessorController::class, 'deleteQuestion'])->name('professor.deleteQuestion');

    // Mostrar la primera pregunta no respondida
    Route::get('/student/answer/{type}', [StudentController::class, 'getFirstUnansweredQuestion'])->name('student.answer');

// Guardar la respuesta del estudiante
Route::post('/student/question/{question}/save', [StudentController::class, 'saveAnswer'])->name('student.saveAnswer');
    });


require __DIR__.'/auth.php';


Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/professor/questions', [ProfessorController::class, 'listQuestions'])->name('professor.questions.list');
Route::delete('/professor/question/{id}', [ProfessorController::class, 'deleteQuestion'])->name('professor.deleteQuestion');

Route::get('/associate-carteles-tarjetas', [CartelController::class, 'showAssociateForm'])->name('cartel.showAssociateForm');
Route::post('/associate-carteles-tarjetas', [CartelController::class, 'associateTarjetaFoto'])->name('cartel.associateTarjetaFoto');
