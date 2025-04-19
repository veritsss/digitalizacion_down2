@extends('layouts.app')
@section('title', 'Responder Pregunta - Asociación')

@section('contenido')
<div class="container">
    <h1 class="text-primary fw-bold">Asociar Imágenes</h1>
    <p class="text-muted fs-4">Selecciona dos imágenes para formar un par.</p>
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
        @foreach($question->images->where('is_answered', false) as $image)
            <div class="col-6 col-md-3 text-center mb-4">
                <!-- Checkbox para seleccionar la imagen -->
                <input type="checkbox" name="selected_images[]" value="{{ $image->image_id }}" id="image_{{ $image->image_id }}" class="btn-check">
                <label for="image_{{ $image->image_id }}" class="btn btn-outline-primary btn-lg w-100 image-container">
                    <img src="{{ asset($image->image->path) }}" alt="Imagen {{ $image->image_id }}" class="image-content">
                </label>
            </div>
        @endforeach
    </div>

    <button type="submit" class="btn btn-success btn-lg d-block text-center mt-3">Enviar Respuesta</button>
</form>
</div>
@endsection
