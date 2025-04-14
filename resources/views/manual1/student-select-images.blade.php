@extends('layouts.app')
@section('title', 'Seleccionar Respuesta Correcta')

@section('contenido')
<div class="container">
    <h1 class="text-primary fw-bold">Seleccionar Respuesta Correcta</h1>
    <p class="text-muted fs-4">Selecciona las imágenes que consideres correctas.</p>

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

    <form id="student-images-form" action="{{ route('student.checkAnswer') }}" method="POST">
        @csrf
        <div class="row">
            @foreach($images as $questionImage)
                <div class="col-6 col-md-3 text-center mb-4">
                    <input type="checkbox" name="selected_image[]" value="{{ $questionImage->image->id }}" id="image_{{ $questionImage->image->id }}" class="btn-check">
                    <label for="image_{{ $questionImage->image->id }}" class="btn btn-outline-primary btn-lg w-100 image-container">
                        <img src="{{ asset($questionImage->image->path) }}" alt="Imagen {{ $questionImage->image->id }}" class="image-content">
                    </label>
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary btn-lg d-block text-center mt-3">Enviar Respuesta</button>
        <a href="{{ route('manual1') }}" class="btn btn-danger btn-lg d-block text-center mt-3">Salir</a>
    </form>
</div>
@endsection