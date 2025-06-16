@extends('layouts.app')
@section('title', 'Pareo Selección y Dibujo')

@section('contenido')
<div class="container">
   <div class="text-center mb-5">
    @if($folder === 'tarjetas-foto')
        <a href="{{ route('tarjetas-fotos') }}"
            class="btn btn-lg btn-outline-primary d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
            aria-label="Volver al dashboard">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
            </svg>
            <span class="fw-bold">Volver</span>
        </a>
        <h1 class="text-primary fw-bold display-4">Configuración para Tarjetas Fotos</h1>
        <p class="text-muted fs-5">Configura las respuestas correctas para la actividad de Tarjetas Fotos.</p>
        <div class="row justify-content-center">
            <div class="col-md-5 mb-4 d-flex">
                <div class="card shadow-sm border-primary equal-height-card w-100">
                    <div class="card-body text-center d-flex flex-column">
                        <h5 class="card-title text-primary fw-bold">Selecciona las imágenes para configurar las tarjetas</h5>
                        <p class="card-text text-muted flex-grow-1">Selecciona las imágenes para configurar las respuestas correctas.</p>
                        <div class="mt-auto">
                            <a href="{{ route('professor.selectQuestionImagesPageE2', ['folder' => $folder, 'mode' => 'tarjetas-foto']) }}" class="btn btn-primary btn-lg w-100 mt-auto">
                                Configurar Tarjetas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif($folder === 'carteles')
        <a href="{{ route('carteles') }}"
            class="btn btn-lg btn-outline-primary d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
            aria-label="Volver al dashboard">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
            </svg>
            <span class="fw-bold">Volver</span>
        </a>
        <h1 class="text-primary fw-bold display-4">Configuración para Carteles</h1>
        <p class="text-muted fs-5">Configura las respuestas correctas para la actividad de carteles.</p>
        <div class="row justify-content-center">
            <div class="col-md-5 mb-4 d-flex">
                <div class="card shadow-sm border-success equal-height-card w-100">
                    <div class="card-body text-center d-flex flex-column">
                        <h5 class="card-title text-success fw-bold">Selección de Pares</h5>
                        <p class="card-text text-muted flex-grow-1">Asigna pares para configurar las respuestas correctas.</p>
                        <div class="mt-auto">
                            <a href="{{ route('professor.selectQuestionImagesPageE2', ['folder' => $folder, 'mode' => 'pairs']) }}" class="btn btn-success btn-lg w-100 mt-auto">
                                Seleccionar Pares
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif($folder === 'unir')
        <a href="{{ route('unir') }}"
            class="btn btn-lg btn-outline-primary d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
            aria-label="Volver al dashboard">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
            </svg>
            <span class="fw-bold">Volver</span>
        </a>
        <h1 class="text-primary fw-bold display-4">Configuración para Carteles</h1>
        <p class="text-muted fs-5">Configura las respuestas correctas para la actividad de carteles.</p>
        <div class="row justify-content-center">
            <div class="col-md-5 mb-4 d-flex">
                <div class="card shadow-sm border-success equal-height-card w-100">
                    <div class="card-body text-center d-flex flex-column">
                        <h5 class="card-title text-success fw-bold">Selección de Pares</h5>
                        <p class="card-text text-muted flex-grow-1">Asigna pares para configurar las respuestas correctas.</p>
                        <div class="mt-auto">
                            <a href="{{ route('professor.selectQuestionImagesPageE2', ['folder' => $folder, 'mode' => 'unir']) }}" class="btn btn-success btn-lg w-100 mt-auto">
                                Seleccionar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif($folder === 'asociar')
        <a href="{{ route('asociar') }}"
            class="btn btn-lg btn-outline-primary d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
            aria-label="Volver al dashboard">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
            </svg>
            <span class="fw-bold">Volver</span>
        </a>
        <h1 class="text-primary fw-bold display-4">Configuración para Carteles</h1>
        <p class="text-muted fs-5">Configura las respuestas correctas para la actividad de carteles.</p>
        <div class="row justify-content-center">
            <div class="col-md-5 mb-4 d-flex">
                <div class="card shadow-sm border-success equal-height-card w-100">
                    <div class="card-body text-center d-flex flex-column">
                        <h5 class="card-title text-success fw-bold">Selección de Pares</h5>
                        <p class="card-text text-muted flex-grow-1">Asigna pares para configurar las respuestas correctas.</p>
                        <div class="mt-auto">
                            <a href="{{ route('professor.selectQuestionImagesPageE2', ['folder' => $folder, 'mode' => 'asociar']) }}" class="btn btn-success btn-lg w-100 mt-auto">
                                Seleccionar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif($folder === 'seleccion')
        <a href="{{ route('seleccion-asociacion') }}"
            class="btn btn-lg btn-outline-primary d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
            aria-label="Volver al dashboard">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
            </svg>
            <span class="fw-bold">Volver</span>
        </a>
        <h1 class="text-primary fw-bold display-4">Configuración para Carteles</h1>
        <p class="text-muted fs-5">Configura las respuestas correctas para la actividad de carteles.</p>
        <div class="row justify-content-center">
            <div class="col-md-5 mb-4 d-flex">
                <div class="card shadow-sm border-success equal-height-card w-100">
                    <div class="card-body text-center d-flex flex-column">
                        <h5 class="card-title text-success fw-bold">Selección de Pares</h5>
                        <p class="card-text text-muted flex-grow-1">Asigna pares para configurar las respuestas correctas.</p>
                        <div class="mt-auto">
                            <a href="{{ route('professor.selectQuestionImagesPageE2', ['folder' => $folder, 'mode' => 'seleccionyasociacion']) }}" class="btn btn-success btn-lg w-100 mt-auto">
                                Seleccionar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif
    </div>
</div>
<style>
    .equal-height-card {
        min-height: 100%;
        display: flex;
        flex-direction: column;
    }
</style>
@endsection
