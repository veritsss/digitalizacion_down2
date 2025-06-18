@extends('layouts.app')
@section('title', 'PareoPorIgualdad')

@section('contenido')
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

    <h1 class="text-primary fw-bold">PAREO DE IMÁGENES IGUALES</h1>
    <!-- Contenido para Profesores -->
    <h2>¿Qué es el Pareo de Imágenes Iguales?</h2>
    <p>Es una actividad en la que los niños deben identificarse y unir imágenes que sean exactamente iguales. No requiere lectura, pero sí una observación detallada y discriminación visual.</p>
    <h3>Objetivo del pareo de imágenes iguales en la lectoescritura</h3>
    <ul>
        <li>Estimular la percepción visual y la atención.</li>
        <li>Desarrollar habilidades discriminativas necesarias para el reconocimiento de letras y palabras.</li>
        <li>Potenciar la memoria visual.</li>
        <li>Servir como base para la identificación de gráficas en etapas iniciales.</li>
    </ul>
    @if($isProfessor)
    <h3>Sugerencias de actividades para el Pareo por igualdad</h3>
    <ul>
        <li>Parear los dibujos iguales.</li>
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


    <a href="{{ route('professor.selectConfigurationModeE1','pareoporigualdad') }}" class="btn btn-primary btn-lg d-block text-center mt-3">
        Comenzar con el Pareo por igualdad
    </a>

    @else
    <!-- Contenido para Estudiantes -->
    <div class="mt-4">

        <a href="{{ route('student.answer', ['type' => 'pareoporigualdad']) }}" class="btn btn-primary btn-lg">
            Responder Preguntas de Pareo por igualdad
        </a>
    </div>
@endif
</div>
@endsection
