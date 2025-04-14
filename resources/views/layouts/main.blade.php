<!-- resources/views/layouts/main.blade.php --> 

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi Plataforma')</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Aquí puedes agregar tus estilos CSS personalizados */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #740b0b;
            color: #8f2e2e;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #4CAF50;
            color: rgb(160, 10, 10);
            padding: 20px;
            text-align: center;
        }

        .container {
            width: 90%;
            margin: 0 auto;
        }

        .content {
            background-color: rgb(121, 25, 25);
            padding: 20px;
            border-radius: 8px
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        footer {
            background-color: #000000;
            color: rgb(151, 26, 26);
            padding: 10px;
            text-align: center;
            margin-top: 40px;
        }
    </style>
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
