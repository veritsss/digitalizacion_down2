@extends('layouts.app')
@section('title', 'Series')

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

    <h1 class="text-primary fw-bold">SERIES</h1>
    <!-- Contenido para Profesores -->
    <h2>¿Qué son las Series?</h2>
    <p>Las series son secuencias ordenadas según un patrón lógico. En lectoescritura se utilizan series de tamaño (grande, mediano, pequeño) o series temporales (primero, luego, después, al final).</p>
    <h3>Objetivo de las series en la lectoescritura</h3>
    <ul>
        <li>Fomentar la lógica secuencial.</li>
        <li>Desarrollar el pensamiento anticipatorio.</li>
        <li>Comprender el orden de los acontecimientos (clave para la narrativa).</li>
        <li>Estimular la organización del discurso oral y escrito.</li>
        <li>Trabajar la estructura y coherencia textual desde etapas tempranas.</li>
    </ul>

    @if($isProfessor)

    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <a href="{{ route('professor.selectConfigurationMode','series') }}" class="btn btn-primary btn-lg d-block text-center mt-3">
        Comenzar con las Series
    </a>

    @else
    <!-- Contenido para Estudiantes -->
    <div class="mt-4">
        @if(isset($message))
            <div class="alert alert-info">
                {{ $message }}
            </div>
        @else
        <a href="{{ route('student.answer', ['type' => 'series']) }}" class="btn btn-primary btn-lg">
            Responder Preguntas de Series
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
