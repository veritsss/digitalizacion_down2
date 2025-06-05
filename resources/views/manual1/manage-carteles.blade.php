@extends('layouts.app')
@section('title', 'Gestionar Carteles')

@section('contenido')
<div class="container">
    <h1 class="text-primary fw-bold">Gestionar Carteles</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Listado de carteles -->
    <h2 class="text-primary fw-bold">Carteles Existentes</h2>
    <div class="row">
        @foreach($carteles as $cartel)
            <div class="col-6 col-md-3 text-center mb-4">
                <button class="btn btn-outline-primary btn-lg w-100 cartel-button" data-cartel-id="{{ $cartel->id }}">
                    <p class="cartel-text">{{ $cartel->text }}</p>
                </button>
            </div>
        @endforeach
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const cartelButtons = document.querySelectorAll('.cartel-button');
    let selectedCartels = [];

    cartelButtons.forEach(button => {
        button.addEventListener('click', function () {
            const cartelId = this.dataset.cartelId;

            // Marcar o desmarcar el botón como activo
            if (selectedCartels.includes(cartelId)) {
                selectedCartels = selectedCartels.filter(id => id !== cartelId);
                this.classList.remove('active');
            } else {
                if (selectedCartels.length < 2) {
                    selectedCartels.push(cartelId);
                    this.classList.add('active');
                }
            }

            // Si hay dos carteles seleccionados, realizar la acción
            if (selectedCartels.length === 2) {
                console.log(`Parear carteles: ${selectedCartels[0]} y ${selectedCartels[1]}`);
                Swal.fire({
                    icon: 'success',
                    title: 'Carteles Pareados',
                    text: `Has pareado los carteles con ID ${selectedCartels[0]} y ${selectedCartels[1]}.`,
                });

                // Reiniciar selección
                selectedCartels.forEach(id => {
                    const button = document.querySelector(`.cartel-button[data-cartel-id="${id}"]`);
                    button.classList.remove('active');
                });
                selectedCartels = [];
            }
        });
    });
});
</script>
@endsection
