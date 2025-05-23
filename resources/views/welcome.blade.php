@extends('layouts.app')
@section('title', 'Manual Etapa 1')

@section('contenido')
<div class="container mb-5">
    <div class="text-center">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6">Digitalización del manual Palabras + Palabras</h1>
        <p class="text-lg text-gray-700 dark:text-gray-300 mb-4">

    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <p class="text-gray-700 dark:text-gray-300 mb-4">
            Este manual cuenta con un conjunto de recursos didácticos para favorecer el acceso temprano a la lectura para estudiantes no lectores que presentan NEE.
        </p>
        <p class="text-gray-700 dark:text-gray-300 mb-4">
            Material elaborado en el año 2008 por la Fundación Down-21 en colaboración con la Unidad de Educación Especial del Ministerio de Educación. Esta propuesta consta de material organizado en cuadernillos dirigido a niños y niñas, otro a las familias y otro dirigido a los profesores y profesoras.
        </p>
        <p class="text-gray-700 dark:text-gray-300 mb-4">
            Se presenta de manera gradual, paulatina y práctica; exponiendo en detalle los pasos a seguir, las secuencias de trabajo y los errores que hay que evitar, para conseguir que los niños, niñas y jóvenes logren los aprendizajes esperados. Para alcanzar este propósito se utiliza un lenguaje claro y simple, sin gran tecnicismo, lo que sin duda, posibilita su aplicación tanto por profesores y profesoras de educación regular, especial y la familia.
        </p>
       <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Consta de 5 Manuales:</h2>
        <ul class="list-disc list-inside text-gray-700 dark:text-gray-300">
            <li>
                <a href="{{ asset('manuals/Manual_Profesor.pdf') }}" target="_blank" class="text-blue-600 hover:underline">
                    Manual para los y las docentes
                </a>
            </li>
            <li>
                <a href="{{ asset('manuals/Manual_Familia.pdf') }}" target="_blank" class="text-blue-600 hover:underline">
                    Manual para la familia
                </a>
            </li>
            <li>
                <a href="{{ asset('manuals/Manual_Estudiantes_Etapa1.pdf') }}" target="_blank" class="text-blue-600 hover:underline">
                    Manual para estudiantes 1ª etapa
                </a>
            </li>
            <li>
                <a href="{{ asset('manuals/Manual_Estudiantes_Etapa2.pdf') }}" target="_blank" class="text-blue-600 hover:underline">
                    Manual para estudiantes 2ª etapa
                </a>
            </li>
            <li>
                <a href="{{ asset('manuals/Manual_Estudiantes_Etapas_3y4.pdf') }}" target="_blank" class="text-blue-600 hover:underline">
                    Manual para estudiantes 3ª y 4ª etapa
                </a>
            </li>
        </ul>
    </div>
</div>
@endsection


