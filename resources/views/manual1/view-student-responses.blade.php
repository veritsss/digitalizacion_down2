@extends('layouts.app')
@section('title', 'Respuestas del Estudiante')

@section('contenido')
<div class="container">
    <h1 class="text-primary fw-bold">Respuestas del Estudiante</h1>
    <h2 class="mb-4">Alumno: {{ $student->name }}</h2>

    @if($responses->isEmpty())
        <div class="alert alert-info">
            Este estudiante no ha respondido ninguna pregunta.
        </div>
    @else
        @foreach($responses as $questionId => $answers)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Pregunta: {{ $answers->first()->question->title }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($answers as $answer)
                            <div class="col-6 col-md-3 text-center mb-4">
                                <img src="{{ asset($answer->image->path) }}" alt="Imagen" class="img-fluid rounded shadow-sm">
                                <p class="mt-2">
                                    <strong>Respuesta:</strong> {{ $answer->is_correct ? 'Correcta' : 'Incorrecta' }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <a href="{{ route('manual1') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
