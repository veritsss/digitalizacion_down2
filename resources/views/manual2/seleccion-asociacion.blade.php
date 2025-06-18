@extends('layouts.app')
@section('title', 'Manual Etapa 1')

@section('contenido')
<div class="container">
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
    <h1 class="text-primary fw-bold">SELECCIÓN Y ASOCIACIÓN</h1>
    <h2>¿Qué es selección y asociación?</h2>
    <p>Selección y asociación es una actividad que consiste en identificar palabras o conceptos que se relacionan con dibujos o acciones específicas. En lectoescritura, esta estrategia se utiliza para reforzar la comprensión y asociación entre palabras y representaciones visuales o acciones.</p>
    <h3>Objetivo de selección y asociación en la lectoescritura</h3>
    <ul>
        <li>Estimular la comprensión y el reconocimiento de significados.</li>
        <li>Favorecer la memoria visual y auditiva.</li>
        <li>Relacionar palabras con dibujos o acciones específicas.</li>
        <li>Fomentar el desarrollo del pensamiento lógico-lingüístico.</li>
        <li>Desarrollar habilidades de selección y asociación de conceptos.</li>
    </ul>
     @if($isProfessor)
    <h3>Sugerencias de actividades para selección y asociación</h3>
    <ul>
        <li>Encerrar o mostrar la palabra que se asocia al dibujo.</li>
        <li>Leer las acciones.</li>
        <li>Encerrar o mostrar la palabra que se asocia a la acción.</li>
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
        <a href="{{ route('professor.selectConfigurationModeE2','seleccion') }}" class="btn btn-primary btn-lg d-block text-center mt-3">
            Comenzar con selección y asociación
        </a>

        @else
        <!-- Contenido para Estudiantes -->
        <div class="mt-4">
            <a href="{{ route('student.answerE2', ['type' => 'seleccion']) }}" class="btn btn-primary btn-lg">
                Responder Preguntas de Selección y Asociación
            </a>
        </div>
    @endif
</div>
@endsection
