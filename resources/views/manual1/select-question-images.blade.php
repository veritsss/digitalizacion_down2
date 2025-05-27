@extends('layouts.app')
@section('title', 'Seleccionar Imágenes para la Pregunta')

@section('contenido')
<div class="container">
    <!-- Botón de salir -->
    <a href="{{ route('manual1') }}"
        class="btn btn-outline-danger btn-lg d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
        aria-label="Volver a la página anterior">
         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
         </svg>
         <span class="fw-bold">salir</span>
      </a>

    <h1 class="text-primary fw-bold">Seleccionar Imágenes para la Pregunta</h1>
    <p class="text-muted fs-4">Selecciona las imágenes que deseas incluir en la pregunta.</p>

    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <style>
        .image-container {
            height: 200px; /* Altura fija para todos los cuadros */
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden; /* Oculta cualquier contenido que exceda el cuadro */
            border-radius: 8px; /* Opcional: bordes redondeados */
        }

        .image-content {
            max-height: 100%; /* Ajusta la altura máxima al contenedor */
            max-width: 100%; /* Ajusta el ancho máximo al contenedor */
            object-fit: cover; /* Asegura que las imágenes llenen el cuadro sin distorsión */
        }
    </style>

<form action="{{ route('professor.selectQuestionImages') }}" method="POST">
    @csrf
    <input type="hidden" name="folder" value="{{ $folder }}">
    <input type="hidden" name="mode" value="{{ $mode }}">

    <div class="mb-3">
        <label for="title" class="form-label">Título de la Pregunta</label>
        <input type="text" id="title" name="title" class="form-control" placeholder="Escribe el título de la pregunta" required>
    </div>
    <!-- Mostrar las imágenes -->
    <div class="row">
        @foreach($images as $image)
            <div class="col-6 col-md-3 text-center mb-4">
                <input type="checkbox" name="selected_images[]" value="{{ $image->id }}" id="image_{{ $image->id }}" class="btn-check">
                <label for="image_{{ $image->id }}" class="btn btn-outline-primary btn-lg w-100 image-container">
                    <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                </label>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center gap-3 mt-4">
        <button type="submit" class="btn btn-success btn-lg w-50 py-3">
            Guardar Pregunta
        </button>
    </div>
</form>
</div>
<br>
@endsection
