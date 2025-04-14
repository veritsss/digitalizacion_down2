<nav class="navbar navbar-expand-lg" role="navigation" aria-label="Main navigation">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('dashboard') }}" aria-label="Ir al Dashboard">
            <x-application-logo class="h-9 w-auto" alt="Logo de la aplicación" />
        </a>

        <!-- Botón de hamburguesa (responsive) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Abrir menú de navegación">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menú de navegación -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- Enlace de Dashboard -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}" aria-label="Ir a la página principal">
                        Inicio
                    </a>
                </li>
            </ul>

            <!-- Opciones de usuario autenticado -->
            @auth
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Menú de usuario">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="max-width: 200px;">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}" aria-label="Ir al perfil de usuario">Perfil</a></li>
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
        </div>
    </div>
</nav>

<!-- Ajustes CSS -->
<style>
    body {
        font-family: 'Arial', sans-serif;
    }

    .navbar {
        z-index: 1000; /* Asegura que la barra de navegación esté siempre arriba */
        background-color: #2c3e50; /* Fondo oscuro, igual que el footer */
        color: #ecf0f1; /* Texto claro para contraste */
    }

    .navbar-toggler {
        border-color: #ecf0f1; /* Borde blanco para el botón */
    }

    .navbar-toggler-icon {
        background-color: #ecf0f1; /* Icono de hamburguesa blanco */
    }

    .nav-link.active {
        color: #3498db !important; /* Enlace activo con color azul suave */
    }

    .dropdown-menu {
        min-width: 10rem; /* Limitar el ancho máximo para que no se salga de la pantalla */
        max-width: 100%;
        box-sizing: border-box;
    }

    .dropdown-item {
        white-space: nowrap; /* Evitar que el texto se divida y salga de los márgenes */
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

      
