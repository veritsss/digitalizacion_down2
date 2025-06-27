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
    <h1 class="text-primary fw-bold">ASOCIACIÓN</h1>
    <h2>¿Qué es asociar?</h2>
    <p>Asociar es una actividad que consiste en relacionar un estímulo con otro que guarda una conexión lógica o funcional. En lectoescritura, esta estrategia se utiliza para reforzar la asociación entre conceptos y representaciones visuales.</p>
    <h3>Objetivo de asociar en la lectoescritura</h3>
    <ul>
        <li>Estimular la comprensión y el reconocimiento de significados.</li>
        <li>Favorecer la memoria visual y auditiva.</li>
        <li>Relacionar palabras con objetos o partes del cuerpo.</li>
        <li>Fomentar el desarrollo del pensamiento lógico-lingüístico.</li>
        <li>Establecer relaciones entre conceptos y palabras de forma significativa.</li>
    </ul>
     @if($isProfessor)
    <h3>Sugerencias de actividades para la asociación</h3>
    <ul>
        <li>Leer y asociar el cartel al dibujo correspondiente.</li>
        <li>Observar los dibujos y unir con la palabra correspondiente.</li>
        <li>Leer y parear las palabras iguales.</li>
        <li>Encerrar o mostrar la palabra que representa al dibujo.</li>
        <li>Leer las oraciones y unirlas al dibujo que representan.</li>
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
        <a href="{{ route('professor.selectConfigurationModeE2','asociar') }}" class="btn btn-primary btn-lg d-block text-center mt-3">
            Comenzar con la asociación
        </a>

        @else
        <!-- Contenido para Estudiantes -->
        <div class="mt-4">
            <a href="{{ route('student.answerE2', ['type' => 'asociar']) }}" class="btn btn-primary btn-lg">
                Responder Preguntas de Asociación
            </a>
        </div>
    @endif
</div>
@endsection
