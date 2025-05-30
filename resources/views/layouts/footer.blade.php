<footer class="custom-footer py-4">
    <div class="container">
        <div class="row">
            <!-- Columna 1: Sobre nosotros -->
            <div class="col-12 col-md-4 mb-3 mb-md-0">
                <h5>Sobre el Sitio Web</h5>
                <p>
                    Esta plataforma digitaliza los manuales <strong>Palabras + Palabras. Aprendamos a Leer</strong>, facilitando su acceso y uso en línea.
                    Puedes consultar los manuales originales en el sitio oficial del Mineduc:
                    <a href="https://especial.mineduc.cl/recursos-apoyo-al-aprendizaje/recursos-las-los-docentes/manuales-palabras-palabras-aprendamos-leer/" target="_blank">Ver página</a>.
                </p>
            </div>
            <!-- Columna 2: Otros enlaces -->
            <div class="col-12 col-md-4 mb-3 mb-md-0">
                <h5>Otros enlaces</h5>
                <ul class="list-unstyled">
                    <li><a href="/" class="text-white">Ver manuales</a></li>
                    <li><a href="#" class="text-white">¿Quiénes somos?</a></li>
                    <li><a href="#" class="text-white">Historia</a></li>
                    <li><a href="#" class="text-white">Contacto</a></li>

                </ul>
            </div>
            <!-- Columna 3: Contáctanos -->
            <div class="col-12 col-md-4">
                <h5>Contáctanos</h5>
                <p>Correo: info@example.com</p>
                <p>Teléfono: +123 456 7890</p>
            </div>
        </div>
        <!-- Línea inferior -->
        <div class="text-center mt-3">
            <p>&copy; {{ date('Y') }} Creado por Ignacio Vera</p>
        </div>
    </div>
</footer>

<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        font-size: 16px; /* Tamaño de fuente adecuado */
        line-height: 1.5; /* Espaciado entre líneas */
    }

    main {
        flex: 1; /* Permite que el contenido principal ocupe el espacio disponible */
    }

    footer {
        background-color: #2c3e50 !important; /* Fondo oscuro consistente */
        color: #ecf0f1; /* Texto claro */
        padding: 1rem 0;
        box-shadow: none; /* Elimina cualquier sombra que pueda alterar la percepción del color */
    }

    footer h5 {
        color: #ecf0f1; /* Títulos en blanco */
        font-size: 1.25rem; /* Tamaño adecuado para títulos */
    }

    footer p, footer ul li {
        color: #bdc3c7; /* Texto en gris claro */
    }

    footer a {
        color: #ecf0f1; /* Enlaces en blanco */
        text-decoration: none;
    }

    footer a:hover {
        color: #3498db; /* Azul suave al pasar el mouse */
        text-decoration: underline;
    }

    footer a:focus {
        outline: 3px solid #f39c12; /* Resaltado al enfocarse */
    }

    @media (max-width: 768px) {
        footer h5 {
            font-size: 1.1rem; /* Reducir el tamaño de los títulos en pantallas pequeñas */
        }

        footer p, footer ul li {
            font-size: 0.9rem; /* Reducir el tamaño del texto en pantallas pequeñas */
        }
    }
</style>
