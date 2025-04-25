@extends('layouts.app')
@section('title', 'Pareo Selección y Dibujo')

@section('contenido')
<div class="container">
    <!-- Botón de retroceso -->
    <a href="{{ route('manual1') }}"
    class="btn btn-outline-danger btn-lg d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
    aria-label="Volver a la página anterior">
     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
     </svg>
     <span class="fw-bold">salir</span>
    </a>

   <!-- Título -->
   <div class="text-center mb-5">
    <h1 class="text-primary fw-bold display-4">Seleccionar tipo de Configuración para las preguntas</h1>
    <p class="text-muted fs-5">Elige cómo deseas configurar las respuestas correctas para esta pregunta.</p>
</div>

<!-- Opciones de configuración -->
<div class="row justify-content-center">
    <div class="col-md-5 mb-4">
        <div class="card shadow-sm border-primary">
            <div class="card-body text-center">
                <h5 class="card-title text-primary fw-bold">Selección de Imágenes Correctas</h5>
                <p class="card-text text-muted">Selecciona las imágenes correctas para configurar las respuestas.</p>
                <a href="{{ route('professor.selectQuestionImagesPage', ['folder' => $folder, 'mode' => 'images']) }}" class="btn btn-primary btn-lg w-100">
                    Seleccionar Imágenes
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-5 mb-4">
        <div class="card shadow-sm border-success">
            <div class="card-body text-center">
                <h5 class="card-title text-success fw-bold">Selección de Pares</h5>
                <p class="card-text text-muted">Asigna pares para configurar las respuestas correctas.</p>
                <a href="{{ route('professor.selectQuestionImagesPage', ['folder' => $folder, 'mode' => 'pairs']) }}" class="btn btn-success btn-lg w-100">
                    Seleccionar Pares
                </a>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
