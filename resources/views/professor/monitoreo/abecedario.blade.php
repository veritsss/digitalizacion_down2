@extends('layouts.app')
@section('title', 'Abecedario del Estudiante')

@section('contenido')
<div class="container">
    <a href="{{ route('professor.searchAbecedario') }}"
       class="btn btn-lg btn-outline-primary d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
       aria-label="Volver al manual de la etapa 2">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
        </svg>
        <span class="fw-bold">Volver</span>
    </a>
    <h1 class="text-center mb-4">Abecedario del Estudiante: {{ $student->name }}</h1>

    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="row">
        @php
            // Definir todas las letras del abecedario, incluyendo letras específicas
            $letters = ['A', 'B', 'C', 'CH', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'LL', 'M', 'N', 'Ñ', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        @endphp
  @foreach($letters as $letter)
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="text-center" style="flex: 1;">
                                <h4 class="imprenta-mayus">{{ $letter }}</h4>
                                <h5 class="imprenta-minus">{{ strtolower($letter) }}</h5>
                            </div>
                            <div class="text-center" style="flex: 1;">
                                <h4 class="manuscrita-mayus">{{ $letter }}</h4>
                                <h5 class="manuscrita-minus">{{ strtolower($letter) }}</h5>
                            </div>
                        </div>
                        <hr>
                        <h6 class="text-center text-secondary">Palabras:</h6>
                        <ul class="list-group mb-2">
                            @foreach($student->learnedWords->where('letter', $letter) as $word)
                                <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                                    <span class="small">{{ $word->word }}</span>
                                    <form action="{{ route('professor.deleteLearnedWord', $word->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">X</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                        <form action="{{ route('professor.saveLearnedWords', $student->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="letter" value="{{ $letter }}">
                            <div class="mb-2">
                                <input type="text" name="words[]" class="form-control form-control-sm" placeholder="Nueva palabra" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm w-100">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&family=Pacifico&display=swap" rel="stylesheet">

<style>
    .imprenta-mayus, .manuscrita-mayus {
        font-family: 'Arial', sans-serif;
        font-size: 1.5rem;
        font-weight: bold;
    }

    .imprenta-minus, .manuscrita-minus {
        font-family: 'Dancing Script', cursive;
        font-size: 1.2rem;
        font-weight: normal;
    }

    .card-body {
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 8px;
    }

    .list-group-item {
        font-size: 0.9rem;
        padding: 5px;
    }

    input.form-control-sm {
        font-size: 0.9rem;
    }

    button.btn-sm {
        font-size: 0.8rem;
    }
</style>
@endsection
