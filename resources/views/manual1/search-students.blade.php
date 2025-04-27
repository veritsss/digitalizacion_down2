@extends('layouts.app')
@section('title', 'Buscar Estudiantes')

@section('contenido')
<div class="container">
    <h1 class="text-primary fw-bold">Buscar Estudiantes</h1>

    <form action="{{ route('professor.searchStudents') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o ID del estudiante" required>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </div>
    </form>

    @if(isset($students) && $students->isNotEmpty())
        <ul class="list-group">
            @foreach($students as $student)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $student->name }}
                    <a href="{{ route('professor.viewStudentResponses', $student->id) }}" class="btn btn-sm btn-primary">Ver Respuestas</a>
                </li>
            @endforeach
        </ul>
    @elseif(isset($students))
        <div class="alert alert-info">
            No se encontraron estudiantes.
        </div>
    @endif
</div>
@endsection
