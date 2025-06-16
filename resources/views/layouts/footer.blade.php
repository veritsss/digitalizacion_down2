<footer class="custom-footer py-4">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
                <h5>Sobre el Sitio Web</h5>
                <p>
                    Esta plataforma digitaliza los manuales <strong>Palabras + Palabras. Aprendamos a Leer</strong>, facilitando su acceso y uso en línea.
                    Puedes consultar los manuales originales en el sitio oficial del Mineduc:
                    <a href="https://especial.mineduc.cl/recursos-apoyo-al-aprendizaje/recursos-las-los-docentes/manuales-palabras-palabras-aprendamos-leer/" target="_blank">Ver página</a>.
                </p>
            </div>
            <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
                <h5>Otros enlaces</h5>
                <ul class="list-unstyled">
                    <li><a href="/" class="text-white">Ver manuales</a></li>
                    <li><a href="#" class="text-white">¿Quiénes somos?</a></li>
                    <li><a href="#" class="text-white">Historia</a></li>
                    <li><a href="#" class="text-white">Contacto</a></li>
                </ul>
            </div>
            <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
                <h5>Contáctanos</h5>
                <p>Correo: info@example.com</p>
                <p>Teléfono: +123 456 7890</p>
            </div>
        </div>
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
        margin-bottom: 0.75rem; /* Add some space below headings */
    }

    footer p, footer ul li {
        color: #bdc3c7; /* Texto en gris claro */
        margin-bottom: 0.5rem; /* Add some space below paragraphs and list items */
    }

    footer ul {
        padding-left: 0; /* Remove default padding for unordered lists */
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

    /* Responsividad */
    @media (max-width: 991.98px) { /* Bootstrap's 'md' breakpoint is 768px, 'lg' is 992px. Using 991.98px for consistent behavior before desktop */
        .custom-footer .col-sm-6 {
            margin-bottom: 1.5rem; /* Increase margin for stacked columns on small screens */
        }
        /* La siguiente regla se ha eliminado, ya no es necesaria */
        /* .custom-footer .text-md-start { text-align: center !important; } */
    }

    @media (max-width: 767.98px) { /* Bootstrap's 'sm' breakpoint is 576px, 'md' is 768px. Using 767.98px */
        footer h5 {
            font-size: 1.1rem; /* Adjust title size for small screens */
        }

        footer p, footer ul li {
            font-size: 0.9rem; /* Adjust text size for small screens */
        }

        .custom-footer .col-12 {
            margin-bottom: 1.5rem; /* Ensure consistent spacing when stacked */
        }
        .custom-footer .col-12:last-child {
            margin-bottom: 0; /* Remove bottom margin for the last column when stacked */
        }
    }

    @media (max-width: 575.98px) { /* Extra small devices (phones) */
        footer h5 {
            font-size: 1rem;
        }

        footer p, footer ul li {
            font-size: 0.85rem;
        }
        footer {
            padding: 0.75rem 0; /* Slightly reduce padding on extra small screens */
        }
    }
</style>
