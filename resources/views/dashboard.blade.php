<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .main-header {
            color: #007bff;
        }
        .section-title {
            color: #6c757d;
        }
        .btn-styled {
            background: linear-gradient(90deg, #007bff, #0056b3); /* Gradiente azul */
            color: #fff;
            border: none;
            border-radius: 50px; /* Bordes redondeados */
            padding: 15px 30px;
            font-size: 1.2rem;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra */
            transition: all 0.3s ease;
        }
    </style>

</head>

<body>

    <!-- Navbar -->
    @include('layouts.navbar')

    <!-- Main content -->
    <main class="container mt-4 mb-5"> <!-- Se añadió mb-5 para evitar que el contenido se solape con el footer -->
        <header class="text-center mb-5">
            <h1 class="main-header fw-bold">Palabras + Palabras. Aprendamos a Leer</h1>
            <p class="fs-4 text-muted">Esta plataforma digitaliza los contenidos de los Manuales: Palabras + Palabras. Aprendamos a Leer.</p>
        </header>

        <section>
            @if($isProfessor)
                @if(session('message'))
                    <div class="alert alert-success">
                    {{ session('message') }}
                    </div>
                @endif
                <div class="text-center mb-5">
                    <a href="{{ route('professor.searchStudents') }}" class="btn btn-styled">
                        <i class="fas fa-users"></i> Ver Estudiantes
                    </a>
                </div>
            @endif
            <h2 class="section-title fs-3 fw-bold">Manuales Disponibles</h2>
            <ul class="list-group mb-5"> <!-- Se añadió mb-5 para añadir un margen inferior -->
                <li class="list-group-item py-3">
                    <a href="{{ route('manual1') }}" class="text-decoration-none text-dark">
                        <i class="fas fa-book"></i> 📘 Manual Etapa 1
                    </a>
                </li>
                <li class="list-group-item py-3">
                    <a href="{{ route('manual2') }}" class="text-decoration-none text-dark">
                        <i class="fas fa-book"></i> 📗 Manual Etapa 2
                    </a>
                </li>
                <li class="list-group-item py-3">
                    <a href="{{ route('manual3') }}" class="text-decoration-none text-dark">
                        <i class="fas fa-book"></i> 📕 Manual Etapa 3
                    </a>
                </li>
                <li class="list-group-item py-3">
                    <a href="{{ route('manual4') }}" class="text-decoration-none text-dark">
                        <i class="fas fa-book"></i> 📙 Manual Etapa 4
                    </a>
                </li>
            </ul>
        </section>

    </main>

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
