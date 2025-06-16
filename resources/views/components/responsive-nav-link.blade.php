@props(['active'])

@php
$baseClasses = 'd-block w-100 ps-3 pe-4 py-2 text-start font-medium transition duration-150 ease-in-out'; // Clases base para ambos estados

$activeClasses = 'border-start border-primary text-primary-active bg-primary-subtle-active'; // Clases para estado activo (border-left, color, background)
$defaultClasses = 'border-start border-transparent text-light-secondary hover-text-primary hover-bg-light-hover hover-border-light-hover'; // Clases para estado inactivo

$classes = ($active ?? false)
            ? $baseClasses . ' ' . $activeClasses
            : $baseClasses . ' ' . $defaultClasses;
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
