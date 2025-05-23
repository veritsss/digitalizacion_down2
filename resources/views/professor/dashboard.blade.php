{{-- filepath: resources/views/professor/dashboard.blade.php --}}
@extends('layouts.app')
@section('title', 'Dashboard Profesor')

@section('contenido')
<div class="containe">
    <a href="{{ route('dashboard') }}"
       class="btn btn-lg btn-outline-primary d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
       aria-label="Volver al dashboard">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
        </svg>
        <span class="fw-bold">Volver</span>
    </a>
    <h1 class="mb-4 text-2xl font-bold text-gray-900 dark:text-gray-100">Seguimiento de Estudiantes</h1>
    <div class="table-responsive bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Preguntas respondidas</th>
                    <th>Aciertos / Total posibles</th>
                    <th>Porcentaje de aciertos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->questions_answered }} / {{ $student->questions_total }}</td>
                    <td>{{ $student->total_correct }} / {{ $student->total_possible }}</td>
                    <td>
                        <span class="badge bg-success">{{ $student->accuracy }}%</span>
                    </td>
                    <td>

                        <a href="{{ route('professor.studentDetail', $student->id) }}" class="btn btn-primary btn-sm">
                            Ver más estadísticas
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No hay estudiantes con respuestas registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
