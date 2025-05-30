@extends('layouts.app')

@section('title', 'Preguntas')

@section('contenido')
<div class="container">
    <h1 class="text-primary fw-bold">Preguntas</h1>

    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Tipo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($questions as $question)
                <tr>
                    <td>{{ $question->id }}</td>
                    <td>{{ $question->title }}</td>
                    <td>{{ $question->type }}</td>
                    <td>
                        <a href="{{ route('professor.questions.edit', $question->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('professor.questions.delete', $question->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $questions->links() }}
</div>
@endsection
