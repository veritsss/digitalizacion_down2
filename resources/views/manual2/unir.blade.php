@extends('layouts.app')
@section('title', 'Manual Etapa 2')

@section('contenido')
<div class="container">
    <!-- Botón de regreso con mejor accesibilidad y estilo -->
    <a href="{{ route('manual2') }}" 
       class="btn btn-lg btn-outline-primary d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
       aria-label="Volver al manual de la etapa 2">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
        </svg>
        <span class="fw-bold">Volver</span>
    </a>

    <!-- Título y contenido con diseño mejorado -->
    <h1 class="text-primary fw-bold">Unir</h1>
    <p class="text-muted fs-5">Este manual corresponde a la etapa 2 de la plataforma de estudiantes.</p>

    <p class="lead">En esta etapa, aprenderás a unir elementos clave para reforzar habilidades de asociación y comprensión.</p>
</div>
@endsection
