@extends('layouts.app')
@section('title', 'Seleccionar Imágenes Correctas')

@section('contenido')
<div class="container">

     <a href="{{ url()->previous() }}"
        class="btn btn-lg btn-outline-primary d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
        aria-label="Volver a la página anterior">
         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
         </svg>
         <span class="fw-bold">Volver</span>
      </a>

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

<form id="correct-images-form" action="{{ route('professor.saveCorrectImages', ['folder' => $folder]) }}" method="POST">
    @csrf
    <input type="hidden" name="question_id" value="{{ session('question_id') }}">
    <input type="hidden" name="folder" value="{{ $folder }}">

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
    <div class="d-flex justify-content-between mt-4">
        <!-- Botón de Salir -->
        <a href="{{ route('manual1') }}" class="btn btn-outline-danger btn-lg">
            Salir
        </a>

        <!-- Botón de Siguiente -->
        <a href="{{ route('professor.selectQuestionImagesPage', ['folder' => $folder]) }}" class="btn btn-primary btn-lg">
            Siguiente
        </a>
    </div>
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
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor.');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert(data.message || 'Respuestas correctas guardadas.');
        } else {
            alert(data.message || 'Ocurrió un error al guardar las respuestas.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ocurrió un error inesperado. Por favor, inténtalo de nuevo.');
    });
});
</script>
@endsection
