@extends('layouts.app')
@section('title', 'Manual Etapa 1')

@section('contenido')
<div class="container">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Botón de regreso con mejor accesibilidad y estilo -->
    <a href="{{ route('manual2') }}"
       class="btn btn-lg btn-outline-primary d-flex align-items-center gap-2 shadow-sm rounded-pill mb-4 px-4 py-2"
       aria-label="Volver al manual de la etapa 2">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
        </svg>
        <span class="fw-bold">Volver</span>
    </a>
    @if(session('message'))
    <script>
        Swal.fire({
            title: '{{ session('alert-type') === 'success' ? '¡Éxito!' : '¡Alerta!' }}',
            text: '{{ session('message') }}',
            icon: '{{ session('alert-type') }}', // Tipo de alerta (success, error, info, etc.)
            confirmButtonText: 'Aceptar'
        });
    </script>
@endif
    <h1 class="text-primary fw-bold">CARTELES</h1>
    <h2>¿Qué son los Carteles?</h2>
    <p>Los Carteles son herramientas visuales que permiten asociar palabras o frases con imágenes, conceptos o acciones específicas. Son ideales para reforzar la comprensión lectora y la asociación de significados en la lectoescritura.</p>

    <h3>Objetivo de los Carteles en la lectoescritura</h3>
    <ul>
        <li>Estimular la comprensión y el reconocimiento de significados.</li>
        <li>Favorecer la memoria visual y auditiva.</li>
        <li>Relacionar símbolos con objetos reales o acciones específicas.</li>
        <li>Fomentar el desarrollo del pensamiento lógico-lingüístico.</li>
        <li>Establecer relaciones entre conceptos y palabras de forma significativa.</li>
    </ul>

    @if($isProfessor)
    <h3>Sugerencias de actividades con los Carteles</h3>
    <ul>
        <li>Relacionar carteles entre sí según su significado.</li>
    </ul>

    </ul>
    <p><strong>Cualquier duda sobre la creación de las actividades puede consultar los manuales:</strong></p>
    <ul>
            <li>
                <a href="{{ asset('manuals/Manual_Profesor.pdf') }}" target="_blank" class="text-blue-600 hover:underline">
                    Manual para los y las docentes
                </a>
            </li>
            <li>
                <a href="{{ asset('manuals/Manual_Estudiantes_Etapa2.pdf') }}" target="_blank" class="text-blue-600 hover:underline">
                    Manual para estudiantes 2<span class="align-text-top" style="font-size: 0.8em;">da</span> etapa
                </a>
            </li>
        </p>
    </ul>

        <a href="{{ route('professor.selectConfigurationModeE2','carteles') }}" class="btn btn-primary btn-lg d-block text-center mt-3">
            Comenzar con los carteles
        </a>

        @else
        <!-- Contenido para Estudiantes -->
        <div class="mt-4">
            <a href="{{ route('student.answerE2', ['type' => 'carteles']) }}" class="btn btn-primary btn-lg">
                Responder Preguntas de los carteles
            </a>
        </div>
    @endif
</div>
@endsection
