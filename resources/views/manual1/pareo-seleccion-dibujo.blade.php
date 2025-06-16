@extends('layouts.app')
@section('title', 'Pareo Selección y Dibujo')

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

    <h1 class="text-primary fw-bold">PAREO SELECCIÓN Y DIBUJO</h1>
    <!-- Contenido para Profesores -->
    <h2>¿Qué es el Pareo?</h2>
    <p>El pareo es un ejercicio de correlación que se utiliza en la lectoescritura para asociar palabras, símbolos, números, frases u oraciones. Es una actividad que ayuda a los niños a desarrollar habilidades perceptivas y discriminativas.</p>
    <h3>Objetivo del pareo en la lectoescritura</h3>
    <ul>
        <li>Desarrollar habilidades de aprendizaje de la lectoescritura en etapas iniciales</li>
        <li>Construir el aprendizaje de forma significativa</li>
        <li>Reconocer sílabas</li>
        <li>Trabajar los diferentes niveles del lenguaje de forma lúdica</li>
    </ul>
    @if($isProfessor)
    <h3>Sugerencias de actividades para el pareo y selección</h3>
    <ul>
        <li>Mostrar la imagen que se nombra.</li>
        <li>Parear las partes del cuerpo que son iguales.</li>
        <li>Buscar dónde está “….” con la imagen tapada. </li>

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
        <a href="{{ route('professor.selectConfigurationModeE1','pareoyseleccion') }}" class="btn btn-primary btn-lg d-block text-center mt-3">
            Comenzar con el Pareo, selección y dibujo
        </a>

        @else
        <!-- Contenido para Estudiantes -->
        <div class="mt-4">
            @if(isset($message))
                <div class="alert alert-info">
                    {{ $message }}
                </div>
            @else
            <a href="{{ route('student.answer', ['type' => 'pareoyseleccion']) }}" class="btn btn-primary btn-lg">
                Responder Preguntas de Pareo
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
