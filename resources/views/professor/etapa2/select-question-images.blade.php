@extends('layouts.app')
@section('title', 'Seleccionar Imágenes para la Pregunta')

@section('contenido')
<div class="container">
    <!-- Botón de salir -->
    <a href="{{ route('manual2') }}"
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

<form action="{{ route('professor.selectQuestionImagesE2') }}" method="POST" id="correct-images-form">
    @csrf
    <input type="hidden" name="folder" value="{{ $folder }}">
    <input type="hidden" name="mode" value="{{ $mode }}">

    <div class="mb-3">
        <label for="title" class="form-label">Título de la Pregunta</label>
        <div class="input-group">
            <!-- Selección de opciones predefinidas -->
            <select id="predefined-title" class="form-select" required>
                <option value="" disabled selected>Selecciona un tipo de pregunta</option>
                <option value="Seleccionar la imagen correcta: ">Seleccionar la imagen correcta:</option>
                <option value="Parear imágenes iguales: ">Parear imágenes iguales:</option>
                <option value="Completar la secuencia: ">Completar la secuencia:</option>
            </select>
            <!-- Campo para completar el título -->
            <input type="text" id="custom-title" name="title" class="form-control" placeholder="Escribe aquí...">
        </div>
    </div>
       <div class="row">
        @if($folder === 'carteles')
         <div class="mb-3">
        <input type="text" id="search-input" class="form-control" placeholder="Buscar cartel">
    </div>
            <h4>Carteles</h4>
            @foreach($cartels as $image)
                <div class="col-6 col-md-3 text-center mb-4">
                    <input type="checkbox" name="selected_images[]" value="{{ $image->id }}" id="cartel_{{ $image->id }}" class="btn-check">
                    <label for="cartel_{{ $image->id }}" class="btn btn-outline-success btn-lg w-100 image-container">
                        <img src="{{ asset($image->path) }}" alt="Cartel {{ $image->id }}" class="image-content" data-path="{{ asset($image->path) }}">
                </label>
                </div>
            @endforeach
        @elseif($folder === 'tarjetas-foto')
         <div class="mb-3">
        <input type="text" id="search-input" class="form-control" placeholder="Buscar imagen ">
        </div>
            <h4>Tarjetas Foto</h4>
            @foreach($images as $image)
                <div class="col-6 col-md-3 text-center mb-4">
                    <input type="checkbox" name="selected_images[]" value="{{ $image->id }}" id="image_{{ $image->id }}" class="btn-check">
                    <label for="image_{{ $image->id }}" class="btn btn-outline-primary btn-lg w-100 image-container">
                        <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content" data-path="{{ asset($image->path) }}">
                    </label>
                </div>
            @endforeach
        @elseif($folder === 'unir')

         <div class="mb-3">
        <input type="text" id="search-input" class="form-control" placeholder="Buscar imagen o cartel">
        <div class="mt-2">
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('search-input').value='carteles'; document.getElementById('search-input').dispatchEvent(new Event('input'));">Solo Carteles</button>
            <button type="button" class="btn btn-outline-success btn-sm" onclick="document.getElementById('search-input').value='tarjetas-foto'; document.getElementById('search-input').dispatchEvent(new Event('input'));">Solo Tarjetas-Foto</button>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="document.getElementById('search-input').value=''; document.getElementById('search-input').dispatchEvent(new Event('input'));">Ver Todos</button>
        </div>
    </div>
            <h4>Tarjetas Foto</h4>
            @foreach($images as $image)
                <div class="col-6 col-md-3 text-center mb-4">
                    <input type="checkbox" name="selected_images[]" value="{{ $image->id }}" id="image_{{ $image->id }}" class="btn-check">
                    <label for="image_{{ $image->id }}" class="btn btn-outline-primary btn-lg w-100 image-container">
                        <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="image-content" data-path="{{ asset($image->path) }}">
                    </label>
                </div>
            @endforeach
            <h4>Carteles</h4>
            @foreach($cartels as $image)
                <div class="col-6 col-md-3 text-center mb-4">
                    <input type="checkbox" name="selected_images[]" value="{{ $image->id }}" id="cartel_{{ $image->id }}" class="btn-check">
                    <label for="cartel_{{ $image->id }}" class="btn btn-outline-success btn-lg w-100 image-container">
                        <img src="{{ asset($image->path) }}" alt="Cartel {{ $image->id }}" class="image-content" data-path="{{ asset($image->path) }}">
                    </label>
                </div>
            @endforeach
        @endif
    </div>

    <div class="d-flex justify-content-center gap-3 mt-4">
        <button type="submit" class="btn btn-success btn-lg w-50 py-3">
            Guardar Pregunta
        </button>
    </div>
</form>
</div>
<br>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const predefinedTitle = document.getElementById('predefined-title');
    const customTitle = document.getElementById('custom-title');
    const folder = document.querySelector('input[name="folder"]').value.trim(); // Obtener el valor de folder y eliminar espacios

    // Opciones predefinidas según el folder (type)
    const optionsByFolder = {
        pareoyseleccion: [
            "Seleccione la imagen que corresponda a: ",
            "Pareee las partes del cuerpo que son iguales: ",
        ],
        asociacion: [
            "Muestre los objetos que se usen para: ",
            "Paree los objetos que están relacionados: ",
        ],
        clasificacionHabitat: [
            "Agrupar y pegar todos los animales que viven en el campo:",
            "Agrupar y pegar todos los animales que viven en la selva: ",
        ],
        clasificacionColor: [
            "Agrupar las fichas según el color: ",
        ],
        clasificacionCategoria: [
            "Parear las imágenes iguales: ",
            "Parear las imágenes que correspondan a la categoría: ",
        ],
        pareoporigualdad: [
            "Paree los dibujos iguales: ",
        ],
        seriesTamaño: [
            "Ordenar imágenes por tamaño: ",
            "Completar según el modelo: ",
        ],
        seriesTemporales: [
            "Ordena la secuencia: ",
        ],
        'tarjetas-foto': [ // Clave con guion
            "Seleccione el texto asociado a cada imagen: ",
            "Asocie las imágenes con sus textos correspondientes: ",
        ],
        carteles: [
            "Paree los carteles iguales: ",
        ],
    };

    // Llenar las opciones del select según el folder
    if (optionsByFolder[folder]) {
        predefinedTitle.innerHTML = ""; // Limpiar opciones existentes
        predefinedTitle.innerHTML = '<option value="" disabled selected>Selecciona un tipo de pregunta</option>';
        optionsByFolder[folder].forEach(option => {
            const opt = document.createElement('option');
            opt.value = option;
            opt.textContent = option;
            predefinedTitle.appendChild(opt);
        });
    } else {
        console.error(`No se encontraron opciones para el folder: ${folder}`);
    }

    // Validar antes de enviar el formulario
    document.getElementById('correct-images-form').addEventListener('submit', function (e) {
        if (!predefinedTitle.value) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: 'Por favor, selecciona un tipo de pregunta.',
            });
            return;
        }

        // Combinar el título predefinido con el texto personalizado (si existe)
        document.getElementById('custom-title').value = predefinedTitle.value + (customTitle.value || '');
    });

    // Buscador para filtrar imágenes/carteles por path o texto alternativo
    const searchInput = document.getElementById('search-input');
searchInput.addEventListener('input', function () {
    const search = this.value.toLowerCase();
    document.querySelectorAll('#correct-images-form .col-6').forEach(function (item) {
        let text = '';
        const img = item.querySelector('img');
        if (img) {
            text += (img.getAttribute('alt') ? img.getAttribute('alt').toLowerCase() : '');
            text += ' ';
            text += (img.getAttribute('data-path') ? img.getAttribute('data-path').toLowerCase() : '');
        }
        const label = item.querySelector('label');
        if (label) {
            text += ' ' + label.textContent.toLowerCase();
        }
        if (text.includes(search)) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
});
});
</script>
@endsection
