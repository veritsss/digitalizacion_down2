@extends('layouts.app')
@section('title', 'Abecedario del Estudiante')

@section('contenido')
<div class="container">
    <a href="{{ route('professor.searchFrases') }}"
       class="btn btn-lg btn-outline-primary d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
       aria-label="Volver al manual de la etapa 2">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5.5 0 0 1 15 8z"/>
        </svg>
        <span class="fw-bold">Volver</span>
    </a>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary fw-bold">Libros personales de: {{ $student->name }}</h1>
        <a href="{{ route('professor.listPhrases', $student->id) }}" class="btn btn-lg btn-primary rounded-pill px-5 py-3 fw-bold">
            Ver frases creadas
        </a>
    </div>

    <!-- Formulario para buscar imágenes -->
    <form id="search-form" class="mb-4">
        <div class="input-group shadow-sm">
            <input type="text" id="search" name="search" class="form-control rounded-pill" placeholder="Buscar imágenes por palabra clave">
        </div>
    </form>

    <!-- Contenedor para mostrar las imágenes -->
    <div id="images-list" class="row g-4">
        <!-- Las imágenes se cargarán aquí dinámicamente -->
    </div>

    <!-- Formulario para crear la frase -->
    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <h2 class="text-center text-success fw-bold mb-4">Crea los libros Personales</h2>
            <form action="{{ route('professor.createPhrase', $student->id) }}" method="POST">
                @csrf
                <input type="hidden" name="student_id" value="{{ $student->id }}">
                <input type="hidden" name="image_id" id="selected-image-id">
                <div class="mb-3">
                    <label for="word" class="form-label fw-bold">Palabra:</label>
                    <input type="text" name="word" id="word" class="form-control rounded-pill shadow-sm" placeholder="Escribe la palabra correspondiente" required>
                </div>
                <div class="mb-3">
                    <label for="phrase" class="form-label fw-bold">Frase, oración, historia:</label>
                    <textarea name="phrase" id="phrase" class="form-control shadow-sm rounded-3" rows="3" placeholder="Escribe una frase utilizando la palabra" required></textarea>
                </div>
                <button type="submit" class="btn btn-success w-100 rounded-pill shadow-sm">Guardar Frase</button>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('message'))
        Swal.fire({
            icon: '{{ session('alert-type', 'info') }}', // Tipo de alerta: success, error, info, etc.
            title: '{{ session('message') }}', // Mensaje de la alerta
            showConfirmButton: false,
            timer: 3000 // Tiempo en milisegundos para que desaparezca automáticamente
        });
    @endif

    document.getElementById('search').addEventListener('input', function () {
        const query = this.value;

        fetch(`{{ route('professor.searchImages') }}?search=${query}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            const imagesList = document.getElementById('images-list');
            imagesList.innerHTML = '';

            if (data.length > 0) {
                data.forEach(image => {
                    const col = document.createElement('div');
                    col.classList.add('col-md-3', 'col-sm-6');
                    col.innerHTML = `
                        <div class="card shadow-sm">
                            <img src="{{ asset('${image.path}') }}" class="card-img-top" alt="${image.name}" style="max-height: 100px; object-fit: contain;">
                            <div class="card-body text-center">
                                <button type="button" class="btn btn-primary rounded-pill shadow-sm" onclick="selectImage(${image.id}, '${image.path}')">Seleccionar</button>
                            </div>
                        </div>
                    `;
                    imagesList.appendChild(col);
                });
            } else {
                imagesList.innerHTML = '<div class="alert alert-info text-center shadow-sm">No se encontraron imágenes.</div>';
            }
        })
        .catch(error => console.error('Error:', error));
    });

    function selectImage(imageId, imagePath) {
        // Actualizar el campo oculto con el ID de la imagen seleccionada
        document.getElementById('selected-image-id').value = imageId;

        // Mostrar una confirmación visual de la selección
        const images = document.querySelectorAll('.card');
        images.forEach(image => image.classList.remove('border-success')); // Quitar bordes de selección anteriores

        const selectedCard = document.querySelector(`img[src="{{ asset('${imagePath}') }}"]`).closest('.card');
        selectedCard.classList.add('border', 'border-success'); // Agregar borde verde a la imagen seleccionada

        Swal.fire({
            icon: 'success',
            title: 'Imagen seleccionada correctamente.',
            showConfirmButton: false,
            timer: 2000
        });
    }
</script>
@endsection

