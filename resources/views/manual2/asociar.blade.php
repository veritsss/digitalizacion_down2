@extends('layouts.app')
@section('title', 'Manual Etapa 1')

@section('contenido')
<div class="container">
    <!-- Botón de retroceso mejorado para mayor accesibilidad -->
    <a href="{{ route('manual2') }}" 
       class="btn btn-lg btn-outline-primary d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
       aria-label="Volver a la página anterior">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
        </svg>
        <span class="fw-bold">Volver</span>
    </a>

    <!-- Título -->
    <h1 class="text-primary fw-bold">ASOCIAR</h1>

    <!-- Descripción -->
    <p class="text-muted fs-4">Este manual corresponde a la etapa 2 de la plataforma de estudiantes.</p>
    
    <!-- Contexto adicional para el usuario -->
    <p class="lead">En esta etapa, aprenderás a asociar diferentes conceptos dentro de la plataforma. Sigue las instrucciones para completar las actividades con éxito.</p>
</div>
@endsection