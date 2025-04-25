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

    @if($isProfessor)

    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <a href="{{ route('professor.selectConfigurationMode','clasificacion') }}" class="btn btn-primary btn-lg d-block text-center mt-3">
        Comenzar con la Clasificación
    </a>

    @else
    <!-- Contenido para Estudiantes -->
    <div class="mt-4">
        @if(isset($message))
            <div class="alert alert-info">
                {{ $message }}
            </div>
        @else
        <a href="{{ route('student.answer', ['type' => 'clasificacion']) }}" class="btn btn-primary btn-lg">
            Responder Preguntas de Clasificación
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
