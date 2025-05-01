@extends('layouts.app')
@section('title', 'Seleccionar Imágenes Correctas')

@section('contenido')
<div class="container">
    <a href="{{ route('manual1') }}"
    class="btn btn-outline-danger btn-lg d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
    aria-label="Volver a la página anterior">
     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
     </svg>
     <span class="fw-bold">salir</span>
  </a>
    <h1 class="text-primary fw-bold">Seleccionar Imágenes Correctas para la pregunta </h1>
    <p class="text-muted fs-4">Pregunta: {{ $question->title }}</p>


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
        <input type="hidden" name="mode" value="{{ $mode }}">

        <div class="row">
            @if($folder === 'asociacion')
                @if($mode === 'images')
                    @foreach($images as $image)
                        <div class="col-6 col-md-3 text-center mb-4">
                            <input type="checkbox" name="selected_images[]" value="{{ $image->id }}" id="image_{{ $image->id }}" class="btn-check">
                            <label for="image_{{ $image->id }}" class="btn btn-outline-success btn-lg w-100 image-container">
                                <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                            </label>
                        </div>
                    @endforeach
                @elseif($mode === 'pairs')
                    @foreach($images as $image)
                        <div class="col-6 col-md-3 text-center mb-4">
                            <div class="image-container">
                                <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                            </div>
                            <select name="pairs[{{ $image->id }}]" id="pair_{{ $image->id }}" class="form-select mt-2">
                                <option value="">Seleccionar Par</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">Par {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    @endforeach
                @endif
            @elseif($folder === 'pareoyseleccion')
                @if($mode === 'images')
                    @foreach($images as $image)
                        <div class="col-6 col-md-3 text-center mb-4">
                            <input type="checkbox" name="selected_images[]" value="{{ $image->id }}" id="image_{{ $image->id }}" class="btn-check">
                            <label for="image_{{ $image->id }}" class="btn btn-outline-success btn-lg w-100 image-container">
                                <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                            </label>
                        </div>
                    @endforeach
                @elseif($mode === 'pairs')
                    @foreach($images as $image)
                        <div class="col-6 col-md-3 text-center mb-4">
                            <div class="image-container">
                                <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                            </div>
                            <select name="pairs[{{ $image->id }}]" id="pair_{{ $image->id }}" class="form-select mt-2">
                                <option value="">Seleccionar Par</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">Par {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    @endforeach
                @endif
            @elseif($folder === 'clasificacionColor')
                @if($mode === 'images')
                    @foreach($images as $image)
                        <div class="col-6 col-md-3 text-center mb-4">
                            <input type="checkbox" name="selected_images[]" value="{{ $image->id }}" id="image_{{ $image->id }}" class="btn-check">
                            <label for="image_{{ $image->id }}" class="btn btn-outline-success btn-lg w-100 image-container">
                                <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                            </label>
                        </div>
                    @endforeach
                @elseif($mode === 'pairs')
                    @foreach($images as $image)
                        <div class="col-6 col-md-3 text-center mb-4">
                            <div class="image-container">
                                <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                            </div>
                            <select name="pairs[{{ $image->id }}]" id="pair_{{ $image->id }}" class="form-select mt-2">
                                <option value="">Seleccionar Par</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">Par {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    @endforeach
                @endif

                @elseif($folder === 'clasificacionHabitat')
                @if($mode === 'images')
                    @foreach($images as $image)
                        <div class="col-6 col-md-3 text-center mb-4">
                            <input type="checkbox" name="selected_images[]" value="{{ $image->id }}" id="image_{{ $image->id }}" class="btn-check">
                            <label for="image_{{ $image->id }}" class="btn btn-outline-success btn-lg w-100 image-container">
                                <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                            </label>
                        </div>
                    @endforeach
                @elseif($mode === 'pairs')
                    @foreach($images as $image)
                        <div class="col-6 col-md-3 text-center mb-4">
                            <div class="image-container">
                                <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                            </div>
                            <select name="pairs[{{ $image->id }}]" id="pair_{{ $image->id }}" class="form-select mt-2">
                                <option value="">Seleccionar Par</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">Par {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    @endforeach
                @endif

                @elseif($folder === 'clasificacionCategoria')
                @if($mode === 'images')
                    @foreach($images as $image)
                        <div class="col-6 col-md-3 text-center mb-4">
                            <input type="checkbox" name="selected_images[]" value="{{ $image->id }}" id="image_{{ $image->id }}" class="btn-check">
                            <label for="image_{{ $image->id }}" class="btn btn-outline-success btn-lg w-100 image-container">
                                <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                            </label>
                        </div>
                    @endforeach
                @elseif($mode === 'pairs')
                    @foreach($images as $image)
                        <div class="col-6 col-md-3 text-center mb-4">
                            <div class="image-container">
                                <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                            </div>
                            <select name="pairs[{{ $image->id }}]" id="pair_{{ $image->id }}" class="form-select mt-2">
                                <option value="">Seleccionar Par</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">Par {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    @endforeach
                @endif

            @elseif($folder === 'pareoporigualdad')
                @if($mode === 'images')
                    @foreach($images as $image)
                        <div class="col-6 col-md-3 text-center mb-4">
                            <input type="checkbox" name="selected_images[]" value="{{ $image->id }}" id="image_{{ $image->id }}" class="btn-check">
                            <label for="image_{{ $image->id }}" class="btn btn-outline-success btn-lg w-100 image-container">
                                <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                            </label>
                        </div>
                    @endforeach
                @elseif($mode === 'pairs')
                    @foreach($images as $image)
                        <div class="col-6 col-md-3 text-center mb-4">
                            <div class="image-container">
                                <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                            </div>
                            <select name="pairs[{{ $image->id }}]" id="pair_{{ $image->id }}" class="form-select mt-2">
                                <option value="">Seleccionar Par</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">Par {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    @endforeach
                @endif
            @elseif($folder === 'seriesTamaño')
            @if($mode === 'images')
            <div class="col-12 text-center mb-4">
                <h5 class="text-primary fw-bold">Configurar Series por Tamaño</h5>
                <p class="text-muted">Asigna un grupo como correcto para las series por tamaño.</p>
            </div>

            <!-- Seleccionar el grupo correcto -->
            <div class="col-12 text-center mb-4">
                <label for="correct_group" class="form-label fw-bold">Seleccionar Grupo Correcto</label>
                <select name="correct_group" id="correct_group" class="form-select">
                    <option value="">Seleccionar Grupo Correcto</option>
                    <option value="1">Pequeño</option>
                    <option value="2">Mediano</option>
                    <option value="3">Grande</option>
                </select>
            </div>
            @endif
        @endif

        </div>

        <button type="button" id="save-button" class="btn btn-success btn-lg d-block text-center mt-3">Guardar Respuestas Correctas</button>
        <div class="d-flex justify-content-between mt-4">



        <a href="{{ route('professor.selectConfigurationMode', ['folder' => $folder]) }}" class="btn btn-primary btn-lg">
            Siguiente
        </a>
    </div>
    </form>
</div>

<script>
    document.getElementById('save-button').addEventListener('click', function () {
        const form = document.getElementById('correct-images-form');
        const formData = new FormData(form);

        fetch("{{ route('professor.saveCorrectImages',['folder' => $folder]) }}", {
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

