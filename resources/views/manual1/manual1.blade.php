@extends('layouts.app')
@section('title', 'Manual Etapa 1')

@section('contenido')
<div class="container mb-5"> <!-- Se añadió el margen inferior aquí -->
    <!-- Botón de regreso mejorado -->
    <a href="{{ route('dashboard') }}"
       class="btn btn-lg btn-outline-primary d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
       aria-label="Volver al dashboard">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
        </svg>
        <span class="fw-bold">Volver</span>
    </a>

    <!-- Título y contenido con mejor presentación -->
    <h1 class="text-primary fw-bold">Manual Etapa 1</h1>
    <p class="text-muted fs-5">Este manual corresponde a la etapa 1 de la plataforma de estudiantes.</p>

    <p class="lead">En esta etapa los estudiantes realizarán actividades que les permitirán afianzar conocimientos fundamentales en diversas áreas.</p>

    <!-- Lista mejorada -->
    <p class="fs-5 fw-bold text-primary">En esta etapa se abordarán los siguientes temas:</p>
    <ul class="list-group">
        <li class="list-group-item">
            <a href="{{ route('pareo-seleccion-dibujo') }}" class="text-decoration-none text-dark fw-bold">
                🎨 Pareo y selección de dibujo
            </a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('asociacion') }}" class="text-decoration-none text-dark fw-bold">
                🔗 Asociación
            </a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('clasificacion') }}" class="text-decoration-none text-dark fw-bold">
                🖍️ Clasificación (color, categoría, hábitat)
            </a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('pareo-igualdad') }}" class="text-decoration-none text-dark fw-bold">
                ⚖️ Pareo por igualdad
            </a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('series') }}" class="text-decoration-none text-dark fw-bold">
                🔢 Series (tamaño y temporal)
            </a>
        </li>
    </ul>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('message'))
    <script>
        Swal.fire({
            title: '{{ session('alert-type') === 'success' ? '¡Éxito!' : '¡Error!' }}',
            text: '{{ session('message') }}',
            icon: '{{ session('alert-type') }}', // Tipo de alerta (success, error, info, etc.)
            confirmButtonText: 'Aceptar'
        });
    </script>
@endif
@endsection
