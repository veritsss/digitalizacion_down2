@extends('layouts.app')
@section('title', 'Buscar Estudiantes - Abecedario')

@section('contenido')
<div class="container">
    <a href="{{ route('abecedario') }}"
       class="btn btn-lg btn-outline-primary d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
       aria-label="Volver al dashboard">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
        </svg>
        <span class="fw-bold">Volver</span>
    </a>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary fw-bold mb-0">Buscar Estudiantes - Abecedario</h1>
    </div>

    <!-- Campo de búsqueda -->
    <form id="search-form" class="mb-4">
        <div class="input-group">
            <input type="text" id="search" name="search" class="form-control" placeholder="Buscar por nombre, RUT o ID del estudiante">
        </div>
    </form>

    <!-- Contenedor para los resultados -->
    <div id="students-list">
        @if(isset($students) && $students->isNotEmpty())
            <ul class="list-group shadow-sm">
                @foreach($students as $student)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $student->name }} {{ $student->apellido }}</strong> <br>
                            <small class="text-muted">RUT: {{ $student->rut }}</small>
                        </div>
                        <a href="{{ route('professor.abecedario', $student->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-book"></i> Abecedario
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="alert alert-info text-center shadow-sm">
                No se encontraron estudiantes.
            </div>
        @endif
    </div>
</div>

<script>
    document.getElementById('search').addEventListener('input', function () {
        const query = this.value;

        // Realizar la solicitud AJAX
        fetch(`{{ route('professor.searchAbecedario') }}?search=${query}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            const studentsList = document.getElementById('students-list');
            studentsList.innerHTML = '';

            if (data.length > 0) {
                const ul = document.createElement('ul');
                ul.classList.add('list-group');

                data.forEach(student => {
                    const li = document.createElement('li');
                    li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
                    li.innerHTML = `
                        ${student.name} (${student.rut || 'Sin RUT'})
                        <a href="/professor/student/${student.id}/abecedario" class="btn btn-sm btn-primary">Abecedario</a>
                    `;
                    ul.appendChild(li);
                });

                studentsList.appendChild(ul);
            } else {
                studentsList.innerHTML = '<div class="alert alert-info">No se encontraron estudiantes.</div>';
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>
@endsection
