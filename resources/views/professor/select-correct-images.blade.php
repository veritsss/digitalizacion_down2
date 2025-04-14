{{-- filepath: resources/views/professor/select-correct-images.blade.php --}}
@extends('layouts.app')
@section('title', 'Seleccionar Respuestas Correctas')

@section('contenido')
<div class="container">
    <h1 class="text-primary fw-bold">Seleccionar Respuestas Correctas</h1>
    <p class="text-muted fs-4">Selecciona las imágenes correctas para la pregunta: <strong>{{ $question->title }}</strong>.</p>

    <form action="{{ route('professor.saveCorrectImages', $question->id) }}" method="POST">
        @csrf
        <div class="row">
            @foreach($question->images as $image)
                <div class="col-6 col-md-3 text-center mb-4">
                    <input type="checkbox" name="selected_images[]" value="{{ $image->image_id }}" id="image_{{ $image->image_id }}" class="btn-check">
                    <label for="image_{{ $image->image_id }}" class="btn btn-outline-primary btn-lg w-100">
                        <img src="{{ asset($image->image->path) }}" alt="Imagen {{ $image->image_id }}" class="img-fluid">
                    </label>
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-success btn-lg d-block text-center mt-3">Guardar Respuestas Correctas</button>
    </form>
</div>
@endsection
