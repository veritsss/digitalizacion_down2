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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@if(session('message'))
    <script>
        Swal.fire({
            title: '{{ session('alert-type') === 'success' ? '¡Éxito!' : '¡Alerta!' }}',
            text: '{{ session('message') }}',
            icon: '{{ session('alert-type') }}', // Tipo de alerta (success, error, info, etc.)
            confirmButtonText: 'Aceptar'
        });
    </script>
@endif
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
    <h3>Sugerencias de actividades para las Series</h3>
    <ul>
        <li>Agrupar todos los objetos grandes.</li>
        <li>Agrupar todos los objetos pequeños.</li>
        <li>Completar según el modelo.</li>
        <li>Agrupar los objetos según el tamaño, grande, mediano o pequeño.</li>
        <li>Completar la secuencia según el modelo.</li>
        <li>Observar y describir las láminas.</li>
        <li>Ordenar la secuencia.</li>
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

    <a href="{{ route('professor.selectConfigurationModeE1','seriesTamaño') }}" class="btn btn-primary btn-lg d-block text-center mt-3">
        Comenzar con las Series por Tamaño
    </a>
    <a href="{{ route('professor.selectConfigurationModeE1','seriesTemporales') }}" class="btn btn-success btn-lg d-block text-center mt-3">
        Comenzar con las Series Temporales
    </a>

    @else
    <!-- Contenido para Estudiantes -->
    <div class="mt-4">

        <a href="{{ route('student.answer', ['type' => 'seriesTamaño']) }}" class="btn btn-primary btn-lg">
            Responder Preguntas de Series de Tamaño
        </a>
        <a href="{{ route('student.answer', ['type' => 'seriesTemporales']) }}" class="btn btn-success btn-lg">
            Responder Preguntas de Series Temporales
        </a>
    </div>
@endif
</div>
@endsection
