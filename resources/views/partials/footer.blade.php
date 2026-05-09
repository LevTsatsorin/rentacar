<footer class="bg-dark text-white-50 mt-5 py-4">
    <div class="container">
        <div class="row gy-4">
            <section class="col-md-4">
                <h2 class="h5 text-white">RentaCar</h2>
                <p class="mb-0">Alquiler de autos para la ciudad y la ruta. Reservás online, retirás en sucursal.</p>
            </section>

            <nav class="col-md-4" aria-label="Enlaces de pie">
                <ul class="list-unstyled mb-0">
                    <li><a class="link-light" href="{{ route('cars.index') }}">Flota</a></li>
                    <li><a class="link-light" href="{{ route('blog.index') }}">Blog</a></li>
                    <li><a class="link-light" href="{{ route('about') }}">Nosotros</a></li>
                </ul>
            </nav>

            <section class="col-md-4">
                <h2 class="h6 text-white">Contacto</h2>
                <address class="mb-0 fst-normal">
                    <p class="mb-1"><i class="bi bi-geo-alt"></i> Av. Corrientes 2037, CABA</p>
                    <p class="mb-1"><i class="bi bi-telephone"></i> +54 11 5032-0076</p>
                    <p class="mb-0"><i class="bi bi-envelope"></i> hola@rentacar.test</p>
                </address>
            </section>
        </div>

        <hr class="border-secondary my-4">

        <p class="small mb-0 text-center">&copy; {{ date('Y') }} RentaCar · Trabajo práctico — Escuela Da Vinci</p>
    </div>
</footer>
