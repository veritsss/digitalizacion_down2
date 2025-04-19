@extends('layouts.app')
@section('title', 'Seleccionar Modo de Configuración')

@section('contenido')
<div class="container">
    <h1 class="text-primary fw-bold">Seleccionar Modo de Configuración</h1>
    <p class="text-muted fs-4">Elige cómo deseas configurar las respuestas correctas para esta pregunta.</p>

    <div class="d-flex justify-content-center gap-4 mt-5">
        <a href="{{ route('professor.selectQuestionImagesPage', ['folder' => $folder, 'mode' => 'images']) }}" class="btn btn-lg btn-outline-primary">
            Selección de Imágenes Correctas
        </a>
        <a href="{{ route('professor.selectQuestionImagesPage', ['folder' => $folder, 'mode' => 'pairs']) }}" class="btn btn-lg btn-outline-success">
            Selección de Pares
        </a>
    </div>
</div>
@endsection
