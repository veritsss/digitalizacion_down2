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
    <style>
        /* Botón para Clasificación por Color */
        .btn-color {
            background-color: #007bff; /* Azul */
            color: white;
            border: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-color:hover {
            background-color: #0056b3; /* Azul oscuro */
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Botón para Clasificación por Categoría */
        .btn-categoria {
            background-color: #28a745; /* Verde */
            color: white;
            border: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-categoria:hover {
            background-color: #1e7e34; /* Verde oscuro */
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Botón para Clasificación por Hábitat */
        .btn-habitat {
            background-color: #ffc107; /* Amarillo */
            color: black;
            border: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-habitat:hover {
            background-color: #e0a800; /* Amarillo oscuro */
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Botones Responsivos */
        .btn-block {
            width: 100%;
            padding: 20px; /* Aumentar el padding para hacerlos más largos */
            font-size: 1.4rem; /* Aumentar el tamaño de la fuente */
            border-radius: 8px;
            max-width: 800px; /* Aumentar el ancho máximo */
        }
    </style>

    @if($isProfessor)
    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="d-flex flex-column align-items-center gap-3">
        <a href="{{ route('professor.selectConfigurationMode','clasificacionColor') }}"
           class="btn btn-lg btn-color shadow-sm btn-block">
            Clasificación por Color
        </a>
        <a href="{{ route('professor.selectConfigurationMode','clasificacionCategoria') }}"
           class="btn btn-lg btn-categoria shadow-sm btn-block">
            Clasificación por Categoría
        </a>
        <a href="{{ route('professor.selectConfigurationMode','clasificacionHabitat') }}"
           class="btn btn-lg btn-habitat shadow-sm btn-block">
            Clasificación por Hábitat
        </a>
    </div>
@else
    <!-- Contenido para Estudiantes -->
    <div class="d-flex flex-column align-items-center gap-3">
        @if(isset($message))
            <div class="alert alert-info">
                {{ $message }}
            </div>
        @else
        <a href="{{ route('student.answer', ['type' => 'clasificacionColor']) }}"
            class="btn btn-lg btn-color shadow-sm btn-block">
            Responder Preguntas de Clasificación por Color
        </a>
        <a href="{{ route('student.answer', ['type' => 'clasificacionCategoria']) }}"
            class="btn btn-lg btn-categoria shadow-sm btn-block">
            Responder Preguntas de Clasificación por Categoría
        </a>
        <a href="{{ route('student.answer', ['type' => 'clasificacionHabitat']) }}"
            class="btn btn-lg btn-habitat shadow-sm btn-block">
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
