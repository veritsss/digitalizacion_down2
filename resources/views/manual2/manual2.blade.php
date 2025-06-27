@extends('layouts.app')
@section('title', 'Manual Etapa 2')

@section('contenido')
<div class="container">
    <!-- Botón de regreso mejorado -->
    <a href="{{ route('dashboard') }}"
       class="btn btn-lg btn-outline-primary d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
       aria-label="Volver al dashboard">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
        </svg>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <span class="fw-bold">Volver</span>
    </a>

    <!-- Título y contenido con mejor presentación -->
    <h1 class="text-primary fw-bold">Manual Etapa 2</h1>
    <p class="text-muted fs-5">Este manual corresponde a la etapa 2 de la plataforma de estudiantes.</p>

    <p class="lead">En esta etapa los estudiantes trabajarán con diversas actividades para reforzar conceptos fundamentales.</p>

    <!-- Lista mejorada -->
    <p class="fs-5 fw-bold text-primary">En esta etapa se abordarán los siguientes temas:</p>
    <ul class="list-group mb-5">  <!-- Agregado mb-5 para añadir margen inferior -->
        <li class="list-group-item py-3">
            <a href="{{ route('tarjetas-fotos') }}" class="text-decoration-none text-dark fw-bold">
                🖼️ Tarjetas fotos
            </a>
        </li>
        <li class="list-group-item py-3">
            <a href="{{ route('carteles') }}" class="text-decoration-none text-dark fw-bold">
                📜 Carteles
            </a>
        </li>
        <li class="list-group-item py-3">
            <a href="{{ route('unir') }}" class="text-decoration-none text-dark fw-bold">
                🔗 Unir
            </a>
        </li>
        <li class="list-group-item py-3">
            <a href="{{ route('asociar') }}" class="text-decoration-none text-dark fw-bold">
                🔑 Asociar
            </a>
        </li>
        <li class="list-group-item py-3">
            <a href="{{ route('componer') }}" class="text-decoration-none text-dark fw-bold">
                🎶 Componer
            </a>
        </li>
        <li class="list-group-item py-3">
            <a href="{{ route('seleccion-asociacion') }}" class="text-decoration-none text-dark fw-bold">
                🏷️ Selección y asociación
            </a>
        </li>
        <li class="list-group-item py-3">
            <a href="{{ route('libros-personales') }}" class="text-decoration-none text-dark fw-bold">
                📚 Libros personales
            </a>
        </li>
        @if($isProfessor)
        <li class="list-group-item py-3">
            <a href="{{ route('abecedario') }}" class="text-decoration-none text-dark fw-bold">
                🔤 Abecedario
            </a>
        </li>
        @endif
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
