@extends('layouts.app')
@section('title', 'Listado de Preguntas')

@section('contenido')
<a href="{{ route('professor.searchStudents') }}"
       class="btn btn-lg btn-outline-primary d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
       aria-label="Volver al dashboard">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
        </svg>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <span class="fw-bold">Volver</span>
    </a>
<div class="container">
    <h1 class="text-primary fw-bold mb-4">Listado de Preguntas</h1>

    @if(session('message'))
    <script>
        Swal.fire({
            title: '{{ session('alert-type') === 'success' ? '¡Éxito!' : '¡Error!' }}',
            text: '{{ session('message') }}',
            icon: '{{ session('alert-type') }}',
            confirmButtonText: 'Aceptar'
        });
    </script>
    @endif

    <!-- Formulario de búsqueda -->
    <form method="GET" action="{{ route('professor.questions.list') }}" class="mb-4">
        <div class="row g-3">
            <div class="col-md-6">
                <input type="text" name="title" class="form-control" placeholder="Buscar por título" value="{{ request('title') }}">
            </div>
            <div class="col-md-4">
                <select name="type" class="form-select">
                    <option value="">Filtrar por tipo</option>
                    <option value="pareoyseleccion" {{ request('type') == 'pareoyseleccion' ? 'selected' : '' }}>Pareo y Selección</option>
                    <option value="asociacion" {{ request('type') == 'asociacion' ? 'selected' : '' }}>Asociación</option>
                    <option value="clasificacion" {{ request('type') == 'clasificacion' ? 'selected' : '' }}>Clasificación</option>
                    <!-- Agrega más tipos según tu base de datos -->
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Buscar</button>
            </div>
        </div>
    </form>

    @if($questions->isEmpty())
        <div class="alert alert-info">
            No hay preguntas disponibles en la base de datos.
        </div>
    @else
        @foreach($questions as $question)
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Pregunta:{{ $question->title }}</span>
                    <!-- Botón para eliminar la pregunta -->
                    <form action="{{ route('professor.deleteQuestion', $question->id) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm d-flex align-items-center gap-2 delete-button">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48">
                            <linearGradient id="wRKXFJsqHCxLE9yyOYHkza_fYgQxDaH069W_gr1" x1="9.858" x2="38.142" y1="9.858" y2="38.142" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#f44f5a"></stop><stop offset=".443" stop-color="#ee3d4a"></stop><stop offset="1" stop-color="#e52030"></stop></linearGradient><path fill="url(#wRKXFJsqHCxLE9yyOYHkza_fYgQxDaH069W_gr1)" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path><path d="M33.192,28.95L28.243,24l4.95-4.95c0.781-0.781,0.781-2.047,0-2.828l-1.414-1.414	c-0.781-0.781-2.047-0.781-2.828,0L24,19.757l-4.95-4.95c-0.781-0.781-2.047-0.781-2.828,0l-1.414,1.414	c-0.781-0.781-0.781,2.047,0,2.828l4.95,4.95l-4.95,4.95c-0.781,0.781-0.781,2.047,0,2.828l1.414,1.414	c0.781,0.781,2.047,0.781,2.828,0l4.95-4.95l4.95,4.95c0.781,0.781,2.047,0.781,2.828,0l1.414-1.414	C33.973,30.997,33.973,29.731,33.192,28.95z" opacity=".05"></path><path d="M32.839,29.303L27.536,24l5.303-5.303c0.586-0.586,0.586-1.536,0-2.121l-1.414-1.414	c-0.586-0.586-1.536-0.586-2.121,0L24,20.464l-5.303-5.303c-0.586-0.586-1.536-0.586-2.121,0l-1.414,1.414	c-0.586,0.586-0.586,1.536,0,2.121L20.464,24l-5.303,5.303c-0.586,0.586-0.586,1.536,0,2.121l1.414,1.414	c0.586,0.586,1.536,0.586,2.121,0L24,27.536l5.303,5.303c0.586,0.586,1.536,0.586,2.121,0l1.414-1.414	C33.425,30.839,33.425,29.889,32.839,29.303z" opacity=".07"></path><path fill="#fff" d="M31.071,15.515l1.414,1.414c0.391,0.391,0.391,1.024,0,1.414L18.343,32.485	c-0.391,0.391-1.024,0.391-1.414,0l-1.414-1.414c-0.391-0.391-0.391-1.024,0-1.414l14.142-14.142	C30.047,15.124,30.681,15.124,31.071,15.515z"></path><path fill="#fff" d="M32.485,31.071l-1.414,1.414c-0.391,0.391-1.024,0.391-1.414,0L15.515,18.343	c-0.391-0.391-0.391-1.024,0-1.414l1.414-1.414c0.391-0.391,1.024-0.391,1.414,0l14.142,14.142	C32.876,30.047,32.876,30.681,32.485,31.071z"></path>
                            </svg>
                        </button>
                    </form>
                </div>
                <div class="card-body">
                    <div class="row g-3">

                        @foreach($question->images as $image)
                            <div class="col-6 col-md-3 text-center">
                                    <div class="image-container">
                                    <img src="{{ asset($image->image->path) }}" alt="Imagen {{ $image->image->id }}" class="image-content">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

        <div class="d-flex justify-content-center mt-4">
            {{ $questions->links() }} <!-- Paginación -->
        </div>
    @endif
</div>
@endsection
<style>
    .image-container {
        height: 200px; /* Altura fija para el contenedor */
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden; /* Oculta el contenido que exceda el contenedor */
        border-radius: 8px; /* Bordes redondeados */
        border: 1px solid #ddd; /* Borde opcional */
    }

    .image-content {
        max-height: 100%; /* Ajusta la altura máxima al contenedor */
        max-width: 100%; /* Ajusta el ancho máximo al contenedor */
        object-fit: cover; /* Asegura que las imágenes llenen el contenedor sin distorsión */
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-button');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Evitar el envío del formulario

                const form = this.closest('form'); // Obtener el formulario asociado

                Swal.fire({
                    title: '¿Quieres eliminar la pregunta?',
                    text: 'No podrás revertir esta acción.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Enviar el formulario si se confirma
                    }
                });
            });
        });
    });
</script>
