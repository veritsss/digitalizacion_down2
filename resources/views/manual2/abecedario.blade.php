@extends('layouts.app')
@section('title', 'Manual Etapa 1')

@section('contenido')
@if($isProfessor)
<div class="container">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Botón de regreso con mejor accesibilidad y estilo -->
    <a href="{{ route('manual2') }}"
       class="btn btn-lg btn-outline-primary d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
       aria-label="Volver al manual de la etapa 2">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
        </svg>
        <span class="fw-bold">Volver</span>
    </a>
      <h1 class="text-primary fw-bold">ABECEDARIO</h1>
    <h2>¿Qué es el abecedario?</h2>
    <p>El abecedario es una herramienta fundamental en el proceso de lectoescritura. Se completa de manera progresiva durante todo el proceso de aprendizaje, a medida que aumenta el repertorio de palabras que el alumno/a reconoce de forma global.</p>
    <h3>Objetivo del abecedario</h3>
    <ul>
        <li>Desarrollar el reconocimiento global de palabras.</li>
        <li>Ampliar el repertorio lingüístico del estudiante.</li>
        <li>Fortalecer la memoria visual mediante la asociación de palabras con imágenes.</li>
        <li>Fomentar la construcción de un abecedario personalizado y significativo.</li>
    </ul>
    <h3>Metodología</h3>
    <ul>
        <li>Introducción progresiva de palabras simples y familiares.</li>
        <li>Asociación de palabras con imágenes y sonidos para reforzar el aprendizaje.</li>
        <li>Organización de las palabras reconocidas según la letra inicial, formando un abecedario personalizado.</li>
    </ul>
    <h3>Beneficios del abecedario</h3>
    <ul>
        <li>Adaptación al ritmo del estudiante, ajustándose a su nivel de reconocimiento global.</li>
        <li>Fomento de la autonomía en la construcción de su propio abecedario.</li>
        <li>Desarrollo integral del lenguaje mediante la combinación de habilidades visuales, auditivas y lingüísticas.</li>
    </ul>
    <p><strong>Cualquier duda sobre la creación de las actividades puede consultar los manuales:</strong></p>
    <ul>
            <li>
                <a href="{{ asset('manuals/Manual_Profesor.pdf') }}" target="_blank" class="text-blue-600 hover:underline">
                    Manual para los y las docentes
                </a>
            </li>
            <li>
                <a href="{{ asset('manuals/Manual_Estudiantes_Etapa2.pdf') }}" target="_blank" class="text-blue-600 hover:underline">
                    Manual para estudiantes 2<span class="align-text-top" style="font-size: 0.8em;">da</span> etapa
                </a>
            </li>
        </p>
    </ul>
        @if(session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <a href="{{ route('professor.searchAbecedario') }}" class="btn btn-primary btn-lg d-block text-center mt-3">
            Ver Abecedario de alumnos
        </a>

        @else
        <!-- Contenido para Estudiantes -->
        <div class="mt-4">
            @if(isset($message))
                <div class="alert alert-info">
                    {{ $message }}
                </div>
            @else
              <!-- SweetAlert para usuarios no autorizados -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    title: 'Acceso denegado',
                    text: 'Esta página es solo para profesores.',
                    icon: 'error',
                    confirmButtonText: 'Volver al inicio'
                }).then(() => {
                    window.location.href = "{{ route('dashboard') }}";
                });
            </script>
            @endif
        </div>
    @endif
</div>
@endsection
