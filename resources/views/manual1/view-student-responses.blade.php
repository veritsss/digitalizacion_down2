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
        border-radius: 8px; /* Bordes redondeados opcionales */
        border: 1px solid #ddd; /* Borde opcional para mejor visualización */
    }

    .image-content {
        max-height: 100%; /* Ajusta la altura máxima al contenedor */
        max-width: 100%; /* Ajusta el ancho máximo al contenedor */
        object-fit: cover; /* Asegura que las imágenes llenen el contenedor sin distorsión */
    }
</style>
<div class="container">
    <h1 class="text-primary fw-bold">Respuestas del Estudiante</h1>
    <h2 class="mb-4">Alumno: {{ $student->name }}</h2>

    <!-- Formulario para seleccionar el tipo -->
    <form method="GET" action="{{ route('professor.viewStudentResponses', ['studentId' => $student->id]) }}" class="mb-4">
        <label for="type" class="form-label fw-bold">Seleccionar Tipo de Pregunta:</label>
        <select name="type" id="type" class="form-select">
            <option value="">Todos</option>
            <option value="asociacion" {{ request('type') == 'asociacion' ? 'selected' : '' }}>Asociación</option>
            <option value="clasificacionHabitat" {{ request('type') == 'clasificacionHabitat' ? 'selected' : '' }}>Clasificación por habitat</option>
            <option value="clasificacionColor" {{ request('type') == 'clasificacionColor' ? 'selected' : '' }}>Clasificación por color</option>
            <option value="clasificacionCategoria" {{ request('type') == 'clasificacionCategoria' ? 'selected' : '' }}>Clasificación por categoría</option>
            <option value="pareoyseleccion" {{ request('type') == 'pareoyseleccion' ? 'selected' : '' }}>Pareo y Selección</option>
            <option value="seriesTamaño" {{ request('type') == 'seriesTamaño' ? 'selected' : '' }}>Series de tamaño</option>
            <option value="seriesTemporales" {{ request('type') == 'seriesTemporales' ? 'selected' : '' }}>Series temporales</option>
            <option value="pareoporigualdad" {{ request('type') == 'pareoporigualdad' ? 'selected' : '' }}>Pareo Por Igualdad</option>
        </select>
        <button type="submit" class="btn btn-primary mt-3">Filtrar</button>
    </form>

    @if($responses->isEmpty())
        <div class="alert alert-info">
            Este estudiante no ha respondido ninguna pregunta.
        </div>
    @else
        @foreach($responses as $questionId => $answers)
            @if(!$type || $answers->first()->question->type == $type)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Pregunta: {{ $answers->first()->question->title }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($answers as $answer)
                                <div class="col-6 col-md-3 text-center mb-4">
                                    <div class="image-container">
                                        <img src="{{ asset($answer->image->path) }}" alt="Imagen {{ $answer->image->id }}" class="image-content">
                                    </div>
                                    <p class="mt-2">
                                        <strong>Respuesta:</strong> {{ $answer->is_correct ? 'Correcta' : 'Incorrecta' }}
                                    </p>
                                    <p>
                                        <strong>Seleccionadas:</strong>
                                        @foreach(json_decode($answer->selected_images, true) as $selectedImageId)
                                            <img src="{{ asset($answers->first()->question->images->where('image_id', $selectedImageId)->first()->image->path) }}"
                                                 alt="Seleccionada {{ $selectedImageId }}"
                                                 class="image-content"
                                                 style="width: 50px; height: 50px;">
                                        @endforeach
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endif

    <a href="{{ route('manual1') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
