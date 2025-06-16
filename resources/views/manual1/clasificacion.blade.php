@extends('layouts.app')
@section('title', 'Clasificación')

@section('contenido')
<div class="container">
    <!-- Botón de retroceso -->
    <a href="{{ route('manual1') }}"
       class="btn btn-lg btn-outline-primary d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
       aria-label="Volver a la página anterior">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
        </svg>
        <span class="fw-bold">Volver</span>
    </a>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <h1 class="text-primary fw-bold">CLASIFICACIÓN</h1>
    <!-- Contenido para Profesores -->
    <h2>¿Qué es clasificar?</h2>
    <p>Clasificar implica agrupar elementos según una característica común. En la lectoescritura, se puede trabajar clasificando por color, categoría (animales, objetos, alimentos, etc.) o hábitat (mar, selva, ciudad, etc.).</p>
    <h3>Objetivo de clasificar en la lectoescritura</h3>
    <ul>
        <li>Desarrollar la atención y la observación.</li>
        <li>Favorecer la organización mental de la información.</li>
        <li>Reconocer similitudes y diferencias.</li>
        <li>Ampliar el vocabulario y comprensión semántica.</li>
        <li>Trabajar la categorización como base del lenguaje.</li>
    </ul>
    @if($isProfessor)
    <h3>Sugerencias de actividades para la Clasificación</h3>
    <ul>
        <li>Agrupar las fichas según el color.</li>
        <li>Parear las imágenes iguales y reconocer las categorías a las que pertenecen.</li>
        <li>Agrupar y pegar según la categoría a la que corresponde.</li>
        <li>Agrupar y pegar todos los animales que viven en el campo.</li>
        <li>Agrupar y pegar todos los animales que viven en la selva.</li>
    </ul>
    <p><strong>Cualquier duda sobre la creación de las actividades puede consultar los manuales:</strong></p>
    <ul>
            <li>
                <a href="{{ asset('manuals/Manual_Profesor.pdf') }}" target="_blank" class="text-blue-600 hover:underline">
                    Manual para los y las docentes
                </a>
            </li>
            <li>
                <a href="{{ asset('manuals/Manual_Estudiantes_Etapa1.pdf') }}" target="_blank" class="text-blue-600 hover:underline">
                    Manual para estudiantes 1ª etapa
                </a>
            </li>
        </p>
    </ul>


    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('professor.selectConfigurationModeE1','clasificacionColor') }}"
           class="btn btn-primary btn-lg d-block text-center mt-3">
            Clasificación por Color
        </a>
        <a href="{{ route('professor.selectConfigurationModeE1','clasificacionCategoria') }}"
           class="btn btn-success btn-lg d-block text-center mt-3">
            Clasificación por Categoría
        </a>
        <a href="{{ route('professor.selectConfigurationModeE1','clasificacionHabitat') }}"
           class="btn btn-warning btn-lg d-block text-center mt-3">
            Clasificación por Hábitat
        </a>
    </div>
@else
    <!-- Contenido para Estudiantes -->
    <div class="mt-4">
        @if(isset($message))
            <div class="alert alert-info">
                {{ $message }}
            </div>
        @else
        <a href="{{ route('student.answer', ['type' => 'clasificacionColor']) }}"
            class="btn btn-primary btn-lg d-block text-center mt-3">
            Responder Preguntas de Clasificación por Color
        </a>
        <a href="{{ route('student.answer', ['type' => 'clasificacionCategoria']) }}"
           class="btn btn-success btn-lg d-block text-center mt-3">
            Responder Preguntas de Clasificación por Categoría
        </a>
        <a href="{{ route('student.answer', ['type' => 'clasificacionHabitat']) }}"
            class="btn btn-warning btn-lg d-block text-center mt-3">
            Responder Preguntas de Clasificación por Hábitat
        </a>
        @endif
    </div>

    @if(session('message'))
        <div class="alert alert-info">
            {{ session('message') }}
        </div>
    @endif
@endif
</div>
@endsection
