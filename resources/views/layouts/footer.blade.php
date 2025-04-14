<footer class="custom-footer py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>Sobre nosotros</h5>
                <p>We are a company dedicated to providing the best services and products to our customers.</p>
            </div>
            <div class="col-md-4">
                <h5>Otros enlaces</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('inicio') }}" class="text-white">Inicio</a></li>
                    <li><a href="#" class="text-white">¿Quienes somos?</a></li>
                    <li><a href="#" class="text-white">Historia</a></li>
                    <li><a href="#" class="text-white">Contacto</a></li>
                </ul>
            </div>
            <div class="col-md-4">
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
        font-size: 16px; /* Tamaño de fuente adecuado para accesibilidad */
        line-height: 1.5; /* Espaciado entre líneas para mayor legibilidad */
    }

    main {
        flex: 1;
    }

    footer {
        background-color: #2c3e50; /* Fondo oscuro con buen contraste */
        color: #ecf0f1; /* Texto claro y suave para contraste con fondo oscuro */
        padding: 1rem 0;
    }

    footer h5 {
        color: #ecf0f1; /* Títulos en blanco para mejor visibilidad */
        font-size: 1.25rem; /* Tamaño adecuado para títulos */
    }

    footer p, footer ul li {
        color: #bdc3c7; /* Texto de párrafos en un gris suave para contraste */
    }

    footer a {
        color: #ecf0f1; /* Enlaces en blanco para visibilidad */
        text-decoration: none;
    }

    footer a:hover {
        color: #3498db; /* Enlaces de color azul suave al pasar el mouse */
        text-decoration: underline; /* Subrayado al pasar el mouse para mejorar la visibilidad */
    }

    footer a:focus {
        outline: 3px solid #f39c12; /* Resaltado al enfocarse en el enlace (clave para usuarios con discapacidad motora) */
    }
</style>
