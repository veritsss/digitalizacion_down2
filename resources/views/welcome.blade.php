<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Bienvenido</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles -->
        <style>
            body {
                font-family: 'Instrument Sans', sans-serif;
                background-color: #f4f4f4;
                color: #333;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }

            .container {
                text-align: center;
                background: #fff;
                padding: 2rem;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                max-width: 600px;
                width: 100%;
            }

            h1 {
                font-size: 2rem;
                margin-bottom: 1rem;
                color: #222;
            }

            p {
                font-size: 1rem;
                margin-bottom: 1.5rem;
                color: #555;
            }

            .btn {
                display: inline-block;
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
                color: #fff;
                background-color: #007bff;
                border: none;
                border-radius: 4px;
                text-decoration: none;
                transition: background-color 0.3s ease;
            }

            .btn:hover {
                background-color: #0056b3;
            }

            .links {
                margin-top: 1.5rem;
            }

            .links a {
                color: #007bff;
                text-decoration: none;
                margin: 0 0.5rem;
                font-size: 0.9rem;
            }

            .links a:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Bienvenido</h1>
            @if (Route::has('login'))
                <div>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn">Ir al Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn">Iniciar Sesión</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn" style="background-color: #28a745;">Registrarse</a>
                        @endif
                    @endauth
                </div>
            @endif

        </div>
    </body>
</html>
