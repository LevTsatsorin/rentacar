<aside class="admin-sidebar bg-dark text-white d-flex flex-column p-3">
    <a href="{{ route('admin.dashboard') }}" class="navbar-brand text-white fw-bold d-flex align-items-center gap-2 mb-4">
        <i class="bi bi-car-front-fill"></i>
        <span>RentaCar <span class="badge bg-primary align-middle">Admin</span></span>
    </a>

    <nav class="nav nav-pills flex-column gap-1" aria-label="Navegación del panel">
        <a class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
           href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2 me-2"></i>Panel
        </a>
        <a class="nav-link text-white {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}"
           href="{{ route('admin.posts.index') }}">
            <i class="bi bi-newspaper me-2"></i>Blog
        </a>
        <a class="nav-link text-white {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
           href="{{ route('admin.users.index') }}">
            <i class="bi bi-people me-2"></i>Usuarios
        </a>
    </nav>

    <div class="mt-auto pt-3 border-top border-secondary">
        <a class="admin-back-link d-inline-flex align-items-center gap-2" href="{{ route('home') }}">
            <i class="bi bi-box-arrow-left"></i>
            <span>Volver al sitio</span>
        </a>
    </div>
</aside>
