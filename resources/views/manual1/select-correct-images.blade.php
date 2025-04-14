@extends('layouts.app')
@section('title', 'Seleccionar Imágenes Correctas')

@section('contenido')
<div class="container">
    <h1 class="text-primary fw-bold">Seleccionar Imágenes Correctas</h1>
    <p class="text-muted fs-4">Selecciona las imágenes correctas de las seleccionadas anteriormente.</p>

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

    <form id="correct-images-form" action="{{ route('professor.saveCorrectImages') }}" method="POST">
        @csrf
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
        <button type="button" id="save-button" class="btn btn-success btn-lg d-block text-center mt-3">Guardar Respuestas Correctas</button>
        <button type="button" id="next-button" class="btn btn-primary btn-lg d-block text-center mt-3">Siguiente</button>
        <a href="{{ route('manual1') }}" class="btn btn-danger btn-lg d-block text-center mt-3">Salir</a>
    </form>
</div>

<script>
    document.getElementById('save-button').addEventListener('click', function () {
        const form = document.getElementById('correct-images-form');
        const formData = new FormData(form);

        fetch("{{ route('professor.saveCorrectImages') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Respuestas correctas guardadas.');
            } else {
                alert('Ocurrió un error al guardar las respuestas.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    document.getElementById('next-button').addEventListener('click', function () {
        window.location.href = "{{ route('professor.selectQuestionImagesPage') }}";
    });
</script>
@endsection