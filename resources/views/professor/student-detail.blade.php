{{-- filepath: resources/views/professor/student-detail.blade.php --}}
@extends('layouts.app')
@section('title', 'Detalle del Estudiante')

@section('contenido')
<div class="container my-5">
    <h1 class="mb-4 text-2xl font-bold text-gray-900 dark:text-gray-100">
        Detalle de respuestas: {{ $student->name }}
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
                            {{ $detalle['total_imagenes'] > 0
                                ? round(($detalle['imagenes_correctas'] / $detalle['total_imagenes']) * 100, 2)
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
    <a href="{{ route('professor.dashboard') }}" class="btn btn-secondary mt-4">Volver al Dashboard</a>
</div>
@endsection
