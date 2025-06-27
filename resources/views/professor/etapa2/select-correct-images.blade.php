@extends('layouts.app')
@section('title', 'Seleccionar Imágenes Correctas')

@section('contenido')
<div class="container">
    <a href="{{ route('manual2') }}"
    class="btn btn-outline-danger btn-lg d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
    aria-label="Volver a la página anterior">
     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
     </svg>
     <span class="fw-bold">salir</span>
  </a>
    <h1 class="text-primary fw-bold"> {{ $question->title }} </h1>
    <p class="text-muted fs-4">Seleccionar Imágenes Correctas para la pregunta</p>


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
        .cartel-button {
        border: 2px solid #007bff;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        background-color: #f9f9f9;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        cursor: default; /* Cambia el cursor para indicar que no es clickeable */
    }

    .cartel-text {
        font-size: 16px;
        font-weight: bold;
        color: #333;
        margin: 0;
    }
    </style>

<form id="correct-images-form" action="{{ route('professor.saveCorrectImagesE2', ['folder' => $folder]) }}" method="POST">
        @csrf
        <input type="hidden" name="question_id" value="{{ session('question_id') }}">
        <input type="hidden" name="folder" value="{{ $folder }}">
        <input type="hidden" name="mode" value="{{ $mode }}">
        <input type="hidden" name="image_order" id="image-order">
        <div class="row" >
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

                        </div>
                    @endforeach
                @endif
             @elseif($folder === 'carteles')
                @if($mode === 'pairs')
                  @foreach($images as $image)
                        <div class="col-6 col-md-3 text-center mb-4">
                            <div class="image-container">
                                <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                            </div>
                        </div>
                    @endforeach
                @endif
            @elseif($folder === 'asociar')
            @if ($mode === 'asociar')
        <div class="row justify-content-center align-items-start mb-4">
            <div class="col-md-6">
                <h4 class="text-center text-primary">Imágenes</h4>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    @foreach($asociar as $image)
                        <div class="col-6 col-md-3 text-center mb-4">
                            <div class="image-container">
                                <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6">
                <h4 class="text-center text-success">Carteles(Palabras)</h4>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    @foreach($asociar2 as $image)
                        <div class="col-6 col-md-3 text-center mb-4">
                            <div class="image-container">
                                <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
            @elseif ($folder === 'tarjetas-foto')
               @if ($mode === 'tarjetas-foto')
        @foreach ($images as $image)
            <div class="col-6 col-md-3 text-center mb-4" id="images-container">
                <label for="image_{{ $image->id }}" class="btn-lg w-100 image-container">
                    <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                </label>
                <div class="btn btn-outline-primary btn-lg w-100 cartel-button" style="pointer-events: none;">
                    <p class="cartel-text">{{ $image->cartel->text ?? 'Sin cartel asociado' }}</p>
                </div>
                <input type="hidden" name="cartel_ids[{{ $image->id }}]" value="{{ $image->cartel->id ?? '' }}">
            </div>
        @endforeach
    @endif
     @elseif ($folder === 'unir')
    @if ($mode === 'unir')
        <div class="row justify-content-center align-items-start mb-4">
            <div class="col-md-6">
                <h4 class="text-center text-primary">Carteles (Palabras)</h4>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    @foreach($unir as $image)
                        <div class="col-6 col-md-3 text-center mb-4">
                            <div class="image-container">
                                <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6">
                <h4 class="text-center text-success">Tarjetas (Imágenes)</h4>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    @foreach($unir2 as $image)
                        <div class="col-6 col-md-3 text-center mb-4">
                            <div class="image-container">
                                <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    @elseif ($folder === 'componer')
    @if ($mode === 'componer')
        <div class="row justify-content-center align-items-start mb-4">
            <div class="col-md-6">
                <h4 class="text-center text-primary">Carteles (Palabras)</h4>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    @foreach($componer as $image)
                        <div class="col-6 col-md-3 text-center mb-4">
                            <div class="image-container">
                                <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6">
                <h4 class="text-center text-success">Tarjetas (Imágenes)</h4>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    @foreach($componer2 as $image)
                        <div class="col-6 col-md-3 text-center mb-4">
                            <div class="image-container">
                                <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    @elseif ($folder === 'seleccion')
    @if ($mode === 'seleccionyasociacion')
        <div class="row justify-content-center align-items-start mb-4">
            <div class="col-md-6">
                <h4 class="text-center text-primary">Carteles (Palabras)</h4>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    @foreach($seleccion as $image)
                        <div class="col-6 col-md-3 text-center mb-4">
                            <input type="checkbox" name="selected_images[]" value="{{ $image->id }}" id="image_{{ $image->id }}" class="btn-check">
                            <label for="image_{{ $image->id }}" class="btn btn-outline-success btn-lg w-100 image-container">
                                <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6">
                <h4 class="text-center text-success">Tarjetas (Imágenes)</h4>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    @foreach($seleccion2 as $image)
                        <div class="col-6 col-md-3 text-center mb-4">
                            <input type="checkbox" name="selected_images[]" value="{{ $image->id }}" id="image_{{ $image->id }}" class="btn-check">
                            <label for="image_{{ $image->id }}" class="btn btn-outline-success btn-lg w-100 image-container">
                                <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
     @elseif($mode === 'images')
                    @foreach($seleccion as $image)
                        <div class="col-6 col-md-3 text-center mb-4">
                            <input type="checkbox" name="selected_images[]" value="{{ $image->id }}" id="image_{{ $image->id }}" class="btn-check">
                            <label for="image_{{ $image->id }}" class="btn btn-outline-success btn-lg w-100 image-container">
                                <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                            </label>
                        </div>
                    @endforeach
                    @foreach($seleccion2 as $image)
                        <div class="col-6 col-md-3 text-center mb-4">
                            <input type="checkbox" name="selected_images[]" value="{{ $image->id }}" id="image_{{ $image->id }}" class="btn-check">
                            <label for="image_{{ $image->id }}" class="btn btn-outline-success btn-lg w-100 image-container">
                                <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                            </label>
                        </div>
                    @endforeach
    @endif
            @endif

        </div>


       <div class="d-flex justify-content-center gap-3 mt-4">
    <button type="button" id="save-button" class="btn btn-success btn-lg w-50 py-3">
        Guardar Respuestas Correctas
    </button>
    <!-- Botón de Previsualización -->
    <button type="button" class="btn btn-info btn-lg w-50 py-3" data-bs-toggle="modal" data-bs-target="#previewModal">
        Previsualizar
    </button>
    <a href="{{ route('professor.selectConfigurationModeE2', ['folder' => $folder]) }}" class="btn btn-primary btn-lg w-50 py-3" id="next-button">
        Siguiente
    </a>
</div>


<!-- Modal de Previsualización -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">Previsualización de la Pregunta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h1 class="text-primary fw-bold text-center">{{ $question->title }}</h1>

                <form>
                    <div class="row">
                        @if($question->mode === 'pairs')
                            @foreach($question->images as $image)
                                <div class="col-6 col-md-3 text-center mb-4">
                                    <input type="checkbox" name="selected_images[]" value="{{ $image->image_id }}" id="image_{{ $image->image_id }}" class="btn-check">
                                    <label for="image_{{ $image->image_id }}" class="btn btn-outline-primary btn-lg w-100 image-container">
                                        <img src="{{ asset($image->image->path) }}" alt="Imagen {{ $image->image_id }}" class="image-content">
                                    </label>
                                </div>
                            @endforeach
                        @elseif($question->mode === 'tarjetas-foto')
                            @foreach($question->images as $image)
                                <div class="col-6 col-md-4 text-center mb-4">
                                    <div class="card shadow-sm">
                                        <div class="image-container">
                                            <img src="{{ asset($image->image->path) }}" alt="Imagen {{ $image->image_id }}" class="image-content">
                                        </div>
                                        <div class="card-body">
                                            <select name="answers[{{ $image->image_id }}]" class="form-select" required>
                                                <option value="" disabled selected>Selecciona el cartel</option>
                                                @foreach($question->images as $option)
                                                    <option value="{{ $option->cartel->id }}">{{ $option->cartel->text ?? 'Sin cartel asociado' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @elseif($question->mode === 'unir')
                        <div id="pareo-app">
    <div class="row justify-content-center align-items-start mb-4">
        <!-- Unir -->
        <div class="col-md-6">
            <h4 class="text-center text-primary">Unir (Palabras)</h4>
            <div id="unir-container" class="d-flex flex-wrap justify-content-center gap-3">
                @foreach($unir as $image)
                    <div class="col-6 col-md-3 text-center mb-4 unir-item" data-id="{{ $image->image_id }}">
                        <input type="radio" name="unir_id" value="{{ $image->image_id }}" id="unir_{{ $image->image_id }}" class="btn-check">
                        <label for="unir_{{ $image->image_id }}" class="btn btn-outline-primary btn-lg w-100 image-container">
                            <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Unir2 -->
        <div class="col-md-6">
            <h4 class="text-center text-success">Unir2 (Imágenes)</h4>
            <div id="unir2-container" class="d-flex flex-wrap justify-content-center gap-3">
                @foreach($unir2 as $image)
                    <div class="col-6 col-md-3 text-center mb-4 unir2-item" data-id="{{ $image->image_id }}">
                        <input type="radio" name="unir2_id" value="{{ $image->image_id }}" id="unir2_{{ $image->image_id }}" class="btn-check">
                        <label for="unir2_{{ $image->image_id }}" class="btn btn-outline-success btn-lg w-100 image-container">
                            <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

                        @elseif($question->mode === 'asociar')
                         <div id="pareo-app">
    <div class="row justify-content-center align-items-start mb-4">
        <div class="col-md-6">
            <h4 class="text-center text-primary">Asociar (Palabras)</h4>
            <div id="unir-container" class="d-flex flex-wrap justify-content-center gap-3">
                @foreach($asociar as $image)
                    <div class="col-6 col-md-3 text-center mb-4 unir-item" data-id="{{ $image->image_id }}">
                        <input type="radio" name="unir_id" value="{{ $image->image_id }}" id="unir_{{ $image->image_id }}" class="btn-check">
                        <label for="unir_{{ $image->image_id }}" class="btn btn-outline-primary btn-lg w-100 image-container">
                            <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-6">
            <h4 class="text-center text-success">Asociar (Imágenes)</h4>
            <div id="unir2-container" class="d-flex flex-wrap justify-content-center gap-3">
                @foreach($asociar2 as $image)
                    <div class="col-6 col-md-3 text-center mb-4 unir2-item" data-id="{{ $image->image_id }}">
                        <input type="radio" name="unir2_id" value="{{ $image->image_id }}" id="unir2_{{ $image->image_id }}" class="btn-check">
                        <label for="unir2_{{ $image->image_id }}" class="btn btn-outline-success btn-lg w-100 image-container">
                            <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
                        @elseif($question->mode === 'seleccionyasociacion')
                        <div id="pareo-app">
    <div class="row justify-content-center align-items-start mb-4">
        <div class="col-md-6">
            <h4 class="text-center text-primary">Seleccionar (Palabras)</h4>
            <div id="unir-container" class="d-flex flex-wrap justify-content-center gap-3">
                @foreach($seleccion as $image)
                    <div class="col-6 col-md-3 text-center mb-4 unir-item" data-id="{{ $image->image_id }}">
                        <input type="radio" name="unir_id" value="{{ $image->image_id }}" id="unir_{{ $image->image_id }}" class="btn-check">
                        <label for="unir_{{ $image->image_id }}" class="btn btn-outline-primary btn-lg w-100 image-container">
                            <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-6">
            <h4 class="text-center text-success">Asociar (Imágenes)</h4>
            <div id="unir2-container" class="d-flex flex-wrap justify-content-center gap-3">
                @foreach($seleccion2 as $image)
                    <div class="col-6 col-md-3 text-center mb-4 unir2-item" data-id="{{ $image->image_id }}">
                        <input type="radio" name="unir2_id" value="{{ $image->image_id }}" id="unir2_{{ $image->image_id }}" class="btn-check">
                        <label for="unir2_{{ $image->image_id }}" class="btn btn-outline-success btn-lg w-100 image-container">
                            <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content">
                        </label>
                    </div>
                @endforeach
                        @endif
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

    </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('message'))
    <script>
        Swal.fire({
            title: '{{ session('alert-type') === 'success' ? '¡Éxito!' : '¡Error!' }}',
            text: '{{ session('message') }}',
            icon: '{{ session('alert-type') }}', // Tipo de alerta (success, error, warning, info)
            confirmButtonText: 'Aceptar'
        });
    </script>
@endif

<script>
    // Deshabilitar botones hasta guardar
    document.querySelector('a.btn-primary').classList.add('disabled');
    document.querySelector('a.btn-outline-danger').classList.add('disabled');
    let respuestasGuardadas = false;

    // Validar selección antes de guardar
    document.getElementById('save-button').addEventListener('click', function () {
        const form = document.getElementById('correct-images-form');



        const formData = new FormData(form);

        fetch("{{ route('professor.saveCorrectImagesE2',['folder' => $folder]) }}", {
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
                Swal.fire({
                    icon: 'success',
                    title: '¡Guardado!',
                    text: data.message || 'Respuestas correctas guardadas.'
                });
                respuestasGuardadas = true;
                // Habilitar botones
                document.querySelector('a.btn-primary').classList.remove('disabled');
                document.querySelector('a.btn-outline-danger').classList.remove('disabled');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Ocurrió un error al guardar las respuestas.'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error inesperado',
                text: 'Ocurrió un error inesperado. Por favor, inténtalo de nuevo.'
            });
        });
    });
    // Prevenir salir si no se ha guardado
    window.addEventListener('beforeunload', function (e) {
        if (!respuestasGuardadas) {
            e.preventDefault();
            e.returnValue = 'Debes guardar las respuestas antes de salir.';
        }
    });

    // Prevenir click en salir/siguiente si no se ha guardado
    document.querySelectorAll('a.btn-primary, a.btn-outline-danger').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            if (!respuestasGuardadas) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Atención',
                    text: 'Debes guardar las respuestas antes de salir o avanzar.'
                });
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('correct-images-form');
    const previewButton = document.querySelector('[data-bs-target="#previewModal"]');
    const previewContainer = document.getElementById('preview-images-container');

    previewButton.addEventListener('click', function () {
        // Limpiar el contenedor de previsualizaciónImágenes seleccionadas correctamente.
        previewContainer.innerHTML = '';

        // Recopilar todas las imágenes disponibles
        const allImages = Array.from(form.querySelectorAll('input[name="selected_images[]"]'));

        // Mostrar todas las imágenes en el modal
        allImages.forEach(input => {
            const imageElement = document.querySelector(`#${input.id}`).nextElementSibling.querySelector('img');
            if (imageElement) {
                const previewImage = document.createElement('div');
                previewImage.className = 'col-6 col-md-3 text-center mb-4';
                previewImage.innerHTML = `<div class="image-container"><img src="${imageElement.src}" alt="Imagen ${input.value}" class="image-content"></div>`;
                previewContainer.appendChild(previewImage);
            }
        });
    });
});

    document.addEventListener('DOMContentLoaded', function () {
        const predefinedTitle = document.getElementById('predefined-title');
        const customTitle = document.getElementById('custom-title');
        const combinedTitle = document.getElementById('combined-title');

        // Actualizar el campo oculto con el título combinado
        function updateCombinedTitle() {
            combinedTitle.value = predefinedTitle.value + (customTitle.value || '');
        }

        // Escuchar cambios en el select y el input
        predefinedTitle.addEventListener('change', updateCombinedTitle);
        customTitle.addEventListener('input', updateCombinedTitle);

        // Validar antes de enviar el formulario
        document.getElementById('correct-images-form').addEventListener('submit', function (e) {
            if (!predefinedTitle.value || !customTitle.value) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Atención',
                    text: 'Por favor, selecciona un tipo de pregunta y completa el título.',
                });
            }
        });
    });
</script>
@endsection
