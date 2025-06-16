@extends('layouts.app')
@section('title', 'Responder Pregunta')

@section('contenido')
<div class="container">
    <a href="{{ route('manual2') }}"
       class="btn btn-lg btn-outline-primary d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
       aria-label="Volver a la página anterior">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
        </svg>
        <span class="fw-bold">Volver</span>
    </a>
    <h1 class="text-primary fw-bold text-center">{{ $question->title }}</h1>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('message'))
    <script>
        Swal.fire({
            title: '{{ session('alert-type') === 'success' ? '¡Éxito!' : '¡Error!' }}',
            text: '{{ session('message') }}',
            icon: '{{ session('alert-type') }}', // Tipo de alerta (success, error, info, etc.)
            confirmButtonText: 'Aceptar'
        });
    </script>
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

    <form action="{{ route('student.saveAnswerE2', $question->id) }}" method="POST">
        @csrf
        <input type="hidden" name="mode" value="{{ $question->mode }}">


        <div class="row">
            @if($question->mode === 'pairs')

            @php
                $answeredImages = \App\Models\StudentAnswer::where('student_id', auth()->id())
                    ->where('question_id', $question->id)
                    ->where('is_answered', true)
                    ->pluck('image_id')
                    ->toArray();
            @endphp

            @foreach($question->images->whereNotIn('image_id', $answeredImages) as $image)
            <div class="col-6 col-md-3 text-center mb-4">
                <!-- Checkbox para seleccionar la imagen -->
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
@php
    $answeredImages = \App\Models\StudentAnswer::where('student_id', auth()->id())
        ->where('question_id', $question->id)
        ->where('is_answered', true)
        ->pluck('image_id')
        ->toArray();

    $unir = $unir->filter(function($image) use ($answeredImages) {
        return !in_array($image->image_id, $answeredImages);
    });

    $unir2 = $unir2->filter(function($image) use ($answeredImages) {
        return !in_array($image->image_id, $answeredImages);
    });
@endphp

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
                            <img src="{{ asset($image->image->path) }}" alt="Unir {{ $image->image_id }}" class="image-content">
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
                            <img src="{{ asset($image->image->path) }}" alt="Unir2 {{ $image->image_id }}" class="image-content">
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    let selectedUnir = null;
let selectedUnir2 = null;
let pares = [];

function selectUnir(element) {
    document.querySelectorAll('.unir-img').forEach(el => el.classList.remove('selected'));
    element.classList.add('selected');
    selectedUnir = element.getAttribute('data-id');
    tryAddPar();
}

function selectUnir2(element) {
    document.querySelectorAll('.unir2-img').forEach(el => el.classList.remove('selected'));
    element.classList.add('selected');
    selectedUnir2 = element.getAttribute('data-id');
    tryAddPar();
}

function tryAddPar() {
    if (selectedUnir && selectedUnir2) {
        // Evitar pares repetidos
        if (pares.find(par => par.unir === selectedUnir || par.unir2 === selectedUnir2)) {
            alert('Ya seleccionaste esa imagen de unir o unir2 en otro par.');
            return;
        }
        pares.push({ unir: selectedUnir, unir2: selectedUnir2 });
        updatePares();
        // Limpiar selección
        document.querySelectorAll('.unir-img').forEach(el => el.classList.remove('selected'));
        document.querySelectorAll('.unir2-img').forEach(el => el.classList.remove('selected'));
        selectedUnir = null;
        selectedUnir2 = null;
    }
}

function updatePares() {
    let paresList = document.getElementById('pares-list');
    let paresInputs = document.getElementById('pares-inputs');
    paresList.innerHTML = '';
    paresInputs.innerHTML = '';
    pares.forEach((par, idx) => {
        paresList.innerHTML += `<div>Pareja ${idx + 1}: Unir #${par.unir} ⇄ Unir2 #${par.unir2}</div>`;
        paresInputs.innerHTML += `<input type="hidden" name="unir_ids[]" value="${par.unir}">`;
        paresInputs.innerHTML += `<input type="hidden" name="unir2_ids[]" value="${par.unir2}">`;
    });

    // Eliminar imágenes respondidas de la vista
    pares.forEach(par => {
        document.querySelector(`.unir-img[data-id="${par.unir}"]`)?.remove();
        document.querySelector(`.unir2-img[data-id="${par.unir2}"]`)?.remove();
    });
}
</script>

<style>
    .image-container.selected {
        border: 3px solid #007bff;
        box-shadow: 0 0 10px #007bff;
    }
</style>
@elseif($question->mode === 'asociar')
@php
    $answeredImages = \App\Models\StudentAnswer::where('student_id', auth()->id())
        ->where('question_id', $question->id)
        ->where('is_answered', true)
        ->pluck('image_id')
        ->toArray();

    $asociar = $asociar->filter(function($image) use ($answeredImages) {
        return !in_array($image->image_id, $answeredImages);
    });

    $asociar2 = $asociar2->filter(function($image) use ($answeredImages) {
        return !in_array($image->image_id, $answeredImages);
    });
@endphp

<div id="pareo-app">
    <div class="row justify-content-center align-items-start mb-4">
        <!-- Asociar -->
        <div class="col-md-6">
            <h4 class="text-center text-primary">Asociar (Palabras)</h4>
            <div id="asociar-container" class="d-flex flex-wrap justify-content-center gap-3">
                @foreach($asociar as $image)
                    <div class="col-6 col-md-3 text-center mb-4 asociar-img" data-id="{{ $image->image_id }}">
                        <input type="radio" name="asociar_id" value="{{ $image->image_id }}" id="asociar_{{ $image->image_id }}" class="btn-check">
                        <label for="asociar_{{ $image->image_id }}" class="btn btn-outline-primary btn-lg w-100 image-container">
                            <img src="{{ asset($image->image->path) }}" alt="Asociar {{ $image->image_id }}" class="image-content">
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Asociar2 -->
        <div class="col-md-6">
            <h4 class="text-center text-success">Asociar2 (Imágenes)</h4>
            <div id="asociar2-container" class="d-flex flex-wrap justify-content-center gap-3">
                @foreach($asociar2 as $image)
                    <div class="col-6 col-md-3 text-center mb-4 asociar2-img" data-id="{{ $image->image_id }}">
                        <input type="radio" name="asociar2_id" value="{{ $image->image_id }}" id="asociar2_{{ $image->image_id }}" class="btn-check">
                        <label for="asociar2_{{ $image->image_id }}" class="btn btn-outline-success btn-lg w-100 image-container">
                            <img src="{{ asset($image->image->path) }}" alt="Asociar2 {{ $image->image_id }}" class="image-content">
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


<script>
    let selectedAsociar = null;
let selectedAsociar2 = null;
let pares = [];

function selectAsociar(element) {
    document.querySelectorAll('.asociar-img').forEach(el => el.classList.remove('selected'));
    element.classList.add('selected');
    selectedAsociar = element.getAttribute('data-id');
    tryAddPar();
}

function selectAsociar2(element) {
    document.querySelectorAll('.asociar2-img').forEach(el => el.classList.remove('selected'));
    element.classList.add('selected');
    selectedAsociar2 = element.getAttribute('data-id');
    tryAddPar();
}

function tryAddPar() {
    if (selectedAsociar && selectedAsociar2) {
        // Evitar pares repetidos
        if (pares.find(par => par.asociar === selectedAsociar || par.asociar2 === selectedAsociar2)) {
            alert('Ya seleccionaste esa imagen de asociar o asociar2 en otro par.');
            return;
        }
        pares.push({ asociar: selectedAsociar, asociar2: selectedAsociar2 });
        updatePares();
        // Limpiar selección
        document.querySelectorAll('.asociar-img').forEach(el => el.classList.remove('selected'));
        document.querySelectorAll('.asociar2-img').forEach(el => el.classList.remove('selected'));
        selectedAsociar = null;
        selectedAsociar2 = null;
    }
}

function updatePares() {
    let paresList = document.getElementById('pares-list');
    let paresInputs = document.getElementById('pares-inputs');
    paresList.innerHTML = '';
    paresInputs.innerHTML = '';
    pares.forEach((par, idx) => {
        paresList.innerHTML += `<div>Pareja ${idx + 1}: Asociar #${par.asociar} ⇄ Asociar2 #${par.asociar2}</div>`;
        paresInputs.innerHTML += `<input type="hidden" name="asociar_ids[]" value="${par.asociar}">`;
        paresInputs.innerHTML += `<input type="hidden" name="asociar2_ids[]" value="${par.asociar2}">`;
    });

    // Eliminar imágenes respondidas de la vista
    pares.forEach(par => {
        document.querySelector(`.asociar-img[data-id="${par.asociar}"]`)?.remove();
        document.querySelector(`.asociar2-img[data-id="${par.asociar2}"]`)?.remove();
    });
}
</script>
@elseif($question->mode === 'seleccionyasociacion')
@php
    $answeredImages = \App\Models\StudentAnswer::where('student_id', auth()->id())
        ->where('question_id', $question->id)
        ->where('is_answered', true)
        ->pluck('image_id')
        ->toArray();

    $seleccion = $seleccion->filter(function($image) use ($answeredImages) {
        return !in_array($image->image_id, $answeredImages);
    });

    $seleccion2 = $seleccion2->filter(function($image) use ($answeredImages) {
        return !in_array($image->image_id, $answeredImages);
    });
@endphp

<div id="seleccion-app">
    <div class="row justify-content-center align-items-start mb-4">
        <!-- Seleccion -->
        <div class="col-md-6">
            <h4 class="text-center text-primary">Seleccion (Palabras)</h4>
            <div id="seleccion-container" class="d-flex flex-wrap justify-content-center gap-3">
                @foreach($seleccion as $image)
                    <div class="col-6 col-md-3 text-center mb-4 seleccion-img" data-id="{{ $image->image_id }}">
                        <input type="radio" name="seleccion_id" value="{{ $image->image_id }}" id="seleccion_{{ $image->image_id }}" class="btn-check">
                        <label for="seleccion_{{ $image->image_id }}" class="btn btn-outline-primary btn-lg w-100 image-container">
                            <img src="{{ asset($image->image->path) }}" alt="Seleccion {{ $image->image_id }}" class="image-content">
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Seleccion2 -->
        <div class="col-md-6">
            <h4 class="text-center text-success">Seleccion2 (Imágenes)</h4>
            <div id="seleccion2-container" class="d-flex flex-wrap justify-content-center gap-3">
                @foreach($seleccion2 as $image)
                    <div class="col-6 col-md-3 text-center mb-4 seleccion2-img" data-id="{{ $image->image_id }}">
                        <input type="radio" name="seleccion2_id" value="{{ $image->image_id }}" id="seleccion2_{{ $image->image_id }}" class="btn-check">
                        <label for="seleccion2_{{ $image->image_id }}" class="btn btn-outline-success btn-lg w-100 image-container">
                            <img src="{{ asset($image->image->path) }}" alt="Seleccion2 {{ $image->image_id }}" class="image-content">
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    let selectedSeleccion = null;
    let selectedSeleccion2 = null;
    let pares = [];

    function selectSeleccion(element) {
        document.querySelectorAll('.seleccion-img').forEach(el => el.classList.remove('selected'));
        element.classList.add('selected');
        selectedSeleccion = element.getAttribute('data-id');
        tryAddPar();
    }

    function selectSeleccion2(element) {
        document.querySelectorAll('.seleccion2-img').forEach(el => el.classList.remove('selected'));
        element.classList.add('selected');
        selectedSeleccion2 = element.getAttribute('data-id');
        tryAddPar();
    }

    function tryAddPar() {
        if (selectedSeleccion && selectedSeleccion2) {
            // Evitar pares repetidos
            if (pares.find(par => par.seleccion === selectedSeleccion || par.seleccion2 === selectedSeleccion2)) {
                alert('Ya seleccionaste esa imagen de seleccion o seleccion2 en otro par.');
                return;
            }
            pares.push({ seleccion: selectedSeleccion, seleccion2: selectedSeleccion2 });
            updatePares();
            // Limpiar selección
            document.querySelectorAll('.seleccion-img').forEach(el => el.classList.remove('selected'));
            document.querySelectorAll('.seleccion2-img').forEach(el => el.classList.remove('selected'));
            selectedSeleccion = null;
            selectedSeleccion2 = null;
        }
    }

    function updatePares() {
        let paresList = document.getElementById('pares-list');
        let paresInputs = document.getElementById('pares-inputs');
        paresList.innerHTML = '';
        paresInputs.innerHTML = '';
        pares.forEach((par, idx) => {
            paresList.innerHTML += `<div>Pareja ${idx + 1}: Seleccion #${par.seleccion} ⇄ Seleccion2 #${par.seleccion2}</div>`;
            paresInputs.innerHTML += `<input type="hidden" name="seleccion_ids[]" value="${par.seleccion}">`;
            paresInputs.innerHTML += `<input type="hidden" name="seleccion2_ids[]" value="${par.seleccion2}">`;
        });

        // Eliminar imágenes respondidas de la vista
        pares.forEach(par => {
            document.querySelector(`.seleccion-img[data-id="${par.seleccion}"]`)?.remove();
            document.querySelector(`.seleccion2-img[data-id="${par.seleccion2}"]`)?.remove();
        });
    }
</script>

<style>
    .image-container.selected {
        border: 3px solid #007bff;
        box-shadow: 0 0 10px #007bff;
    }
</style>
@endif
    </div>

    <!-- Botón de Enviar Respuesta -->
    <button type="submit" class="btn btn-success btn-lg btn-submit">Enviar Respuesta</button>
</form>

<!-- Botón de Salir -->
<div class="d-flex justify-content-center mt-4">
    <a href="{{ route('manual2') }}" class="btn btn-exit">
        Salir
    </a>
</div>
@endsection
