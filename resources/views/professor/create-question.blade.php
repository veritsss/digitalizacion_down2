{{-- filepath: resources/views/professor/create-question.blade.php --}}
@extends('layouts.app')
@section('title', 'Crear Pregunta')

@section('contenido')
<div class="container">
    <h1 class="text-primary fw-bold">Crear Pregunta</h1>
    <form action="{{ route('professor.selectQuestionImages') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Título de la Pregunta</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>
        <div class="row">
            @foreach($images as $image)
                <div class="col-6 col-md-3 text-center mb-4">
                    <input type="checkbox" name="selected_images[]" value="{{ $image->id }}" id="image_{{ $image->id }}" class="btn-check">
                    <label for="image_{{ $image->id }}" class="btn btn-outline-primary btn-lg w-100">
                        <img src="{{ asset($image->path) }}" alt="Imagen {{ $image->id }}" class="img-fluid">
                    </label>
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-success btn-lg d-block text-center mt-3">Guardar Pregunta</button>
    </form>
</div>
@endsection
