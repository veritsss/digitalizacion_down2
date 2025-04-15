@extends('layouts.app')
@section('title', 'Responder Pregunta')

@section('contenido')
<div class="container">
    <a href="{{ route('manual1') }}"
       class="btn btn-lg btn-outline-primary d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
       aria-label="Volver a la página anterior">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
        </svg>
        <span class="fw-bold">Volver</span>
    </a>
    <h1 class="text-primary fw-bold text-center">{{ $question->title }}</h1>
    <p class="text-muted fs-4 text-center">Selecciona las imágenes que consideres correctas.</p>

    @if(session('message'))
        <div class="alert alert-info alert-dismissible fade show text-center" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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

        .btn-submit {
            font-size: 1.5rem; /* Tamaño de fuente más grande */
            padding: 15px 30px; /* Más espacio interno */
            display: block;
            margin: 20px auto; /* Centrar el botón */
        }

        .btn-exit {
            font-size: 1.2rem; /* Tamaño de fuente ligeramente más pequeño */
            padding: 10px 20px; /* Espaciado interno más pequeño */
            background-color: #dc3545; /* Rojo para el botón de salir */
            color: white; /* Texto blanco */
            border: none; /* Sin borde */
            border-radius: 5px; /* Bordes redondeados */
        }

        .btn-exit:hover {
            background-color: #c82333; /* Rojo más oscuro al pasar el mouse */
        }
    </style>

    <form action="{{ route('student.saveAnswer', $question->id) }}" method="POST">
        @csrf
        <div class="row">
            @foreach($question->images as $image)
                <div class="col-6 col-md-3 text-center mb-4">
                    <input type="checkbox" name="selected_images[]" value="{{ $image->image_id }}" id="image_{{ $image->image_id }}" class="btn-check">
                    <label for="image_{{ $image->image_id }}" class="btn btn-outline-primary btn-lg w-100 image-container">
                        <img src="{{ asset($image->image->path) }}" alt="Imagen {{ $image->image_id }}" class="image-content">
                    </label>
                </div>
            @endforeach
        </div>

        <!-- Botón de Enviar Respuesta -->
        <button type="submit" class="btn btn-success btn-lg btn-submit">Enviar Respuesta</button>
    </form>

    <!-- Botón de Salir -->
    <div class="d-flex justify-content-center mt-4">
        <a href="{{ route('manual1') }}" class="btn btn-exit">
            Salir
        </a>
    </div>
</div>
@endsection
