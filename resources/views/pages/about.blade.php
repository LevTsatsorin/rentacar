@extends('layouts.front')

@section('title', 'Nosotros')
@section('description', 'Quiénes somos en RentaCar y cómo trabajamos.')

@section('content')
    <section class="container py-5">
        <header class="mb-5 text-center">
            <h1 class="fw-bold">Sobre RentaCar</h1>
            <p class="text-muted lead">Una empresa de alquiler de autos pensada para personas reales, no para formularios.</p>
        </header>

        <article class="row g-5 align-items-center mb-5">
            <div class="col-lg-6">
                <h2 class="h3 fw-bold mb-3">Nuestra historia</h2>
                <p>RentaCar nació en 2020 con una idea simple: alquilar un auto debería ser tan fácil como comprar un pasaje. Sin formularios eternos, sin cargos sorpresa, sin esperas en la sucursal.</p>
                <p>Empezamos con cinco vehículos en un local prestado del barrio de Almagro y hoy operamos una flota de más de cincuenta unidades, todas con menos de tres años de antigüedad y mantenimiento al día. Lo que no cambió en estos años es la regla principal: la persona que reserva es la que importa.</p>
                <p>Trabajamos para clientes particulares, viajeros que llegan al país, empresas que necesitan flota temporal y para quien simplemente quiere hacer una escapada de fin de semana. Cada cliente recibe el mismo trato: precio claro, auto en condiciones, soporte cuando hace falta.</p>
            </div>
            <div class="col-lg-6">
                <h2 class="h3 fw-bold mb-3">Cómo trabajamos</h2>
                <ul class="list-unstyled">
                    <li class="mb-3"><i class="bi bi-check-circle-fill text-primary"></i> <strong>Reserva online:</strong> elegís el auto, las fechas y pagás. Listo, sin llamados ni esperas.</li>
                    <li class="mb-3"><i class="bi bi-check-circle-fill text-primary"></i> <strong>Retiro flexible:</strong> sucursal central en Av. Corrientes o entrega en aeropuerto sin costo extra.</li>
                    <li class="mb-3"><i class="bi bi-check-circle-fill text-primary"></i> <strong>Devolución sin sorpresas:</strong> tarifa clara desde el día uno, no cobramos cargos ocultos al recibir el auto.</li>
                    <li class="mb-3"><i class="bi bi-check-circle-fill text-primary"></i> <strong>Mantenimiento al día:</strong> cada vehículo pasa por revisión completa antes de cada alquiler.</li>
                    <li><i class="bi bi-check-circle-fill text-primary"></i> <strong>Soporte 24/7:</strong> atendemos por WhatsApp, teléfono y correo, todos los días del año.</li>
                </ul>
            </div>
        </article>

        <section class="bg-light rounded p-5 mb-5">
            <h2 class="h3 fw-bold mb-4 text-center">Nuestros valores</h2>
            <div class="row g-4">
                <article class="col-md-4">
                    <h3 class="h5 fw-bold"><i class="bi bi-eye text-primary"></i> Transparencia</h3>
                    <p class="text-muted mb-0">Una sola tarifa por día, todos los costos listados antes de pagar. Si algo no está claro, lo aclaramos antes de la reserva, no después.</p>
                </article>
                <article class="col-md-4">
                    <h3 class="h5 fw-bold"><i class="bi bi-clock-history text-primary"></i> Tiempo de la gente</h3>
                    <p class="text-muted mb-0">Reservar tendría que tardar minutos, no una mañana. Por eso simplificamos la web, los retiros y las devoluciones.</p>
                </article>
                <article class="col-md-4">
                    <h3 class="h5 fw-bold"><i class="bi bi-people text-primary"></i> Trato humano</h3>
                    <p class="text-muted mb-0">Atendemos personas, no tickets. Si tenés un problema en la ruta, llamás y te atiende alguien, no un menú de opciones.</p>
                </article>
            </div>
        </section>

        <section class="text-center">
            <h2 class="h3 fw-bold mb-3">¿Listo para empezar?</h2>
            <p class="text-muted mb-4">Mirá la flota disponible o escribinos directamente.</p>
            <a href="{{ route('cars.index') }}" class="btn btn-primary btn-lg me-2">Ver flota</a>
            <a href="#" class="btn btn-outline-primary btn-lg">Contactarnos</a>
        </section>
    </section>
@endsection
