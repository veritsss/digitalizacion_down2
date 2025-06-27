<!-- resources/views/layouts/main.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi Plataforma')</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

</head>
<body>

    <header>
        <h1>Bienvenido a la Plataforma</h1>
    </header>

    <div class="container">
        <!-- Aquí es donde se cargará el contenido de cada página -->
        @yield('content')
    </div>

    <footer>
        <p>&copy; 2025 Mi Plataforma. Todos los derechos reservados.</p>
    </footer>

</body>
</html>
