@extends('layouts.app')
@section('title', 'Respuestas del Estudiante')

@section('contenido')
<style>
    .image-container {
        height: 200px; /* Altura fija para el contenedor */
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden; /* Oculta el contenido que exceda el contenedor */
        border-radius: 8px; /* Bordes redondeados */
        border: 1px solid #ddd; /* Borde opcional */

    }

    .image-content {
        max-height: 100%; /* Ajusta la altura máxima al contenedor */
        max-width: 100%; /* Ajusta el ancho máximo al contenedor */
        object-fit: cover; /* Asegura que las imágenes llenen el contenedor sin distorsión */
    }

    .card-header {
        background-color: #2c3e50; /* Fondo azul */
        color: white; /* Texto blanco */

    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
</style>

<div class="container">
    <!-- Botón de volver -->
    <a href="{{ route('professor.searchStudents') }}"
       class="btn btn-lg btn-outline-primary d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
       aria-label="Volver al dashboard">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
        </svg>
        <span class="fw-bold">Volver</span>
    </a>

    <h1 class="text-primary fw-bold mb-4">Respuestas del Estudiante: {{ $student->name }}</h1>

    <!-- Formulario de filtros -->
    <form method="GET" action="{{ route('professor.viewStudentResponses', ['studentId' => $student->id]) }}" class="mb-4">
        <div class="row g-3">
            <!-- Filtro por tipo -->
            <div class="col-md-4">
                <label for="type" class="form-label fw-bold">Seleccionar Tipo de Pregunta:</label>
                <select name="type" id="type" class="form-select">
                    <option value="">Todos</option>
                    <option value="pareoyseleccion" {{ request('type') == 'pareoyseleccion' ? 'selected' : '' }}>Pareo y Selección</option>
                    <option value="asociacion" {{ request('type') == 'asociacion' ? 'selected' : '' }}>Asociación</option>
                    <option value="clasificacionHabitat" {{ request('type') == 'clasificacionHabitat' ? 'selected' : '' }}>Clasificación por habitat</option>
                    <option value="clasificacionColor" {{ request('type') == 'clasificacionColor' ? 'selected' : '' }}>Clasificación por color</option>
                    <option value="clasificacionCategoria" {{ request('type') == 'clasificacionCategoria' ? 'selected' : '' }}>Clasificación por categoría</option>
                    <option value="pareoporigualdad" {{ request('type') == 'pareoporigualdad' ? 'selected' : '' }}>Pareo Por Igualdad</option>
                    <option value="seriesTamaño" {{ request('type') == 'seriesTamaño' ? 'selected' : '' }}>Series de tamaño</option>
                    <option value="seriesTemporales" {{ request('type') == 'seriesTemporales' ? 'selected' : '' }}>Series temporales</option>
                </select>
            </div>

            <!-- Filtro por nombre -->
            <div class="col-md-4">
                <label for="filter" class="form-label fw-bold">Filtrar por Nombre:</label>
                <input type="text" name="filter" id="filter" class="form-control" placeholder="Buscar por nombre" value="{{ request('filter') }}">
            </div>

            <!-- Ordenar por fecha -->
            <div class="col-md-4">
                <label for="order" class="form-label fw-bold">Ordenar por Fecha:</label>
                <select name="order" id="order" class="form-select">
                    <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Más recientes primero</option>
                    <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Más antiguas primero</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Filtrar</button>
    </form>

    <!-- Mensaje si no hay respuestas -->
    @if($responses->isEmpty())
        <div class="alert alert-info">
            Este estudiante no ha respondido ninguna pregunta de este tipo.
        </div>
    @else
        <!-- Respuestas -->
        @foreach($responses as $questionId => $answers)
            @if(!$type || $answers->first()->question->type == $type)
                <div class="card mb-4">
                    <div class="card-header">
                        Pregunta: {{ $answers->first()->question->title }}
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach($answers as $answer)
                                <div class="col-6 col-md-3 text-center">
                                    <div class="image-container">
                                        <img src="{{ asset($answer->image->path) }}" alt="Imagen {{ $answer->image->id }}" class="image-content">
                                    </div>
                                    <p class="mt-2">
                                        <strong>Respuesta:</strong> {{ $answer->is_correct ? 'Correcto' : 'Incorrecta' }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                        <p class="mt-3">
                            <strong>Respuestas correctas del estudiante:</strong> {{ $statistics[$questionId]['student_correct_answers'] }}<br>
                            <strong>Total de imágenes correctas esperadas:</strong> {{ $statistics[$questionId]['total_correct_images'] }}<br>
                            <strong>Total de imágenes:</strong> {{ $statistics[$questionId]['total_images'] }}
                        </p>
                    </div>
                </div>
            @endif
        @endforeach
    @endif
    <a href="{{ route('manual1') }}" class="btn btn-secondary mt-4">Volver</a>
</div>
<br>
@endsection
