@extends('layouts.app')
@section('title', 'Seleccionar Imágenes para la Pregunta')

@section('contenido')
<div class="container">
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
        <div class="row">
            @foreach($images as $image)
                <div class="col-6 col-md-3 text-center mb-4">
                    <input type="checkbox" name="selected_images[]" value="{{ $image->id }}" id="image_{{ $image->id }}" class="btn-check">
                    <label for="image_{{ $image->id }}" class="btn btn-outline-primary btn-lg w-100 image-container">
                        <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="img-fluid image-content">
                    </label>
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary btn-lg d-block text-center mt-3">Seleccionar Imágenes</button>
    </form>
</div>
@endsection