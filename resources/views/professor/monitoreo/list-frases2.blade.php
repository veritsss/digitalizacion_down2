@extends('layouts.app')
@section('title', 'Abecedario del Estudiante')

@section('contenido')
<div class="container">
    <a href="{{ route('libros-personales') }}"
       class="btn btn-lg btn-outline-primary d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
       aria-label="Volver al manual de la etapa 2">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
        </svg>
        <span class="fw-bold">Volver</span>
    </a>

    <h1 class="text-center mb-4 text-primary fw-bold">Mis Frases</h1>

    <!-- Formulario de búsqueda y filtros -->
    <div class="row g-3 align-items-center mb-4">
        <!-- Buscador -->
        <div class="col-md-9">
            <input type="text" id="search" name="search" class="form-control rounded-pill shadow-sm" placeholder="Buscar por palabra, frase o imagen">
        </div>

        <!-- Ordenar por -->
        <div class="col-md-3 text-end">
            <label for="filter" class="fw-bold me-2">Ordenar por:</label>
            <select id="filter" name="filter" class="form-select rounded-pill shadow-sm">
                <option value="recent">Más recientes</option>
                <option value="oldest">Más antiguos</option>
                <option value="alphabetical">Alfabético (palabra)</option>
                <option value="reverse-alphabetical">Alfabético inverso (palabra)</option>
            </select>
        </div>
    </div>

    <!-- Contenedor para mostrar las frases -->
    <div id="phrases-list" class="row g-4">
        @foreach($phrases as $phrase)
            <div class="col-12">
                <div class="card shadow-sm text-center p-4">
                    <!-- Mostrar la imagen asociada -->
                    <img src="{{ asset($phrase->image->path) }}" class="img-fluid mb-3" alt="{{ $phrase->word }}" style="max-height: 100px; object-fit: contain;">

                    <!-- Mostrar la palabra en rojo -->
                    <h2 class="text-danger fw-bold">{{ $phrase->word }}</h2>

                    <!-- Mostrar la frase en negro -->
                    <p class="fs-4 text-dark">{{ $phrase->phrase }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search');
    const filterSelect = document.getElementById('filter');
    const phrasesList = document.getElementById('phrases-list');

    // Escuchar el evento 'input' en el campo de búsqueda
    searchInput.addEventListener('input', function () {
        performSearch();
    });

    // Escuchar el evento 'change' en el selector de filtros
    filterSelect.addEventListener('change', function () {
        performSearch();
    });

    function performSearch() {
        const query = searchInput.value;
        const filter = filterSelect.value;

        // Realizar la solicitud AJAX
        fetch(`{{ route('professor.searchPhrases', $student->id) }}?search=${query}&filter=${filter}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            phrasesList.innerHTML = '';

            if (data.length > 0) {
                data.forEach(phrase => {
                    const col = document.createElement('div');
                    col.classList.add('col-12');
                    col.innerHTML = `
                        <div class="card shadow-sm text-center p-4">
                            <img src="{{ asset('') }}${phrase.image.path}" class="img-fluid mb-3" alt="${phrase.word}" style="max-height: 100px; object-fit: contain;">
                            <h2 class="text-danger fw-bold">${phrase.word}</h2>
                            <p class="fs-4 text-dark">${phrase.phrase}</p>
                        </div>
                    `;
                    phrasesList.appendChild(col);
                });
            } else {
                phrasesList.innerHTML = '<div class="alert alert-info text-center shadow-sm">No se encontraron frases.</div>';
            }
        })
        .catch(error => console.error('Error:', error));
    }
});
</script>
@endsection
