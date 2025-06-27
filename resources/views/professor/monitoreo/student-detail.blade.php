{{-- filepath: resources/views/professor/student-detail.blade.php --}}
@extends('layouts.app')
@section('title', 'Detalle del Estudiante')

@section('contenido')
 <a href="{{ route('professor.dashboard') }}"
       class="btn btn-lg btn-outline-primary d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
       aria-label="Volver a la página anterior">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
        </svg>
        <span class="fw-bold">Volver</span>
    </a>
<div class="container my-5">
    <h1 class="mb-4 text-2xl font-bold text-gray-900 dark:text-gray-100">
        Detalle de respuestas: {{ $student->name }} {{ $student->apellido }}
    </h1>
    <div class="table-responsive bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Tipo de pregunta</th>
                    <th>Preguntas respondidas / totales</th>
                    <th>Respuestas Correctas</th>
                    <th>Respuestas Incorrectas</th>
                    <th>Respuestas Omitidas</th>
                    <th>% de acierto</th>
                </tr>
            </thead>
            <tbody>
                @forelse($detalles as $detalle)
                <tr>
                    <td>
                        @switch($detalle['type'])
                            @case('pareoyseleccion')
                                Pareo y selección
                                @break
                            @case('asociacion')
                                Asociación
                                @break
                            @case('pareoporigualdad')
                                Pareo por igualdad
                                @break
                            @case('clasificacionHabitat')
                                Clasificación por hábitat
                                @break
                            @case('clasificacionColor')
                                Clasificación por color
                                @break
                            @case('clasificacionCategoria')
                                Clasificación por categoría
                                @break
                            @case('seriesTemporales')
                                Series Temporales
                                @break
                            @case('seriesTamaño')
                                Series por Tamaño
                                @break
                            @default
                                {{ ucfirst(str_replace('_', ' ', $detalle['type'])) }}
                        @endswitch
                    </td>
                    <td>{{ $detalle['preguntas_respondidas'] }} / {{ $detalle['total_preguntas'] }}</td>
                    <td>{{ $detalle['imagenes_correctas'] }}</td>
                    <td>{{ $detalle['imagenes_incorrectas'] }}</td>
                    <td>{{ $detalle['omitidas'] }}</td>
                    <td>
                        <span class="badge bg-success">
                            {{ ($detalle['imagenes_correctas'] + $detalle['imagenes_incorrectas'] + $detalle['omitidas']) > 0
                                ? round(($detalle['imagenes_correctas'] / ($detalle['imagenes_correctas'] + $detalle['imagenes_incorrectas'] + $detalle['omitidas'])) * 100, 2)
                                : 0 }}%
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No hay respuestas registradas para este estudiante.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
