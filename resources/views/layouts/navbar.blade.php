<nav class="navbar navbar-expand-lg" role="navigation" aria-label="Main navigation">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}" aria-label="Ir al Dashboard">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid" style="height: 40px;">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Abrir menú de navegación">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                </ul>

            @auth
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Menú de usuario">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item" aria-label="Cerrar sesión">Cerrar Sesión</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            @endauth

            @guest
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}" aria-label="Iniciar sesión">Iniciar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}" aria-label="Registrarse">Registrarse</a>
                    </li>
                </ul>
            @endguest
        </div>
    </div>
</nav>

<style>
    body {
        font-family: 'Arial', sans-serif;
    }

    .navbar {
        z-index: 1000; /* Asegura que la barra de navegación esté siempre arriba */
        background-color: #2c3e50 !important; /* Fondo oscuro consistente */
        color: #ecf0f1; /* Texto claro para contraste */
        box-shadow: none; /* Elimina cualquier sombra que pueda alterar la percepción del color */
    }

    .navbar-toggler {
        border-color: #ecf0f1; /* Borde blanco para el botón */
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%23ecf0f1' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        /* Icono de hamburguesa blanco usando SVG directamente para mejor compatibilidad */
    }

    .nav-link.active {
        color: #3498db !important; /* Enlace activo con color azul suave */
    }

    .dropdown-menu {
        min-width: 10rem; /* Limitar el ancho máximo para que no se salga de la pantalla */
        max-width: 100%;
        box-sizing: border-box;
        background-color: #2c3e50; /* Fondo del dropdown para que coincida con la navbar */
        border: none; /* Elimina el borde predeterminado */
    }

    .dropdown-item {
        white-space: nowrap; /* Evitar que el texto se divida y salga de los márgenes */
        color: #ecf0f1; /* Color del texto del item del dropdown */
    }

    .dropdown-item:hover,
    .dropdown-item:focus {
        background-color: #34495e; /* Color de fondo al pasar el mouse/enfocar */
        color: #ecf0f1; /* Asegura que el texto siga siendo claro */
    }

    .navbar-nav .nav-link {
        color: #ecf0f1; /* Texto claro para enlaces */
    }

    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link:focus {
        color: #3498db; /* Enlaces de color azul suave al pasar el mouse */
        text-decoration: underline; /* Subrayado al pasar el mouse para mejorar la visibilidad */
    }

    .navbar-nav .nav-link:focus {
        outline: 3px solid #f39c12; /* Resaltado de enlace cuando se enfoca (clave para accesibilidad) */
    }
</style>


