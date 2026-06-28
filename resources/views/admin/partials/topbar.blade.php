<header class="admin-topbar bg-white border-bottom d-flex align-items-center justify-content-between px-3 px-lg-4 py-2">
    <h1 class="h5 mb-0">@yield('page-title', 'Panel de administración')</h1>

    <div class="dropdown">
        <button class="btn btn-sm btn-light dropdown-toggle d-flex align-items-center gap-1" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle"></i>
            <span>{{ auth()->user()->name }}</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('home') }}"><i class="bi bi-globe me-2"></i>Ver sitio público</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión
                    </button>
                </form>
            </li>
        </ul>
    </div>
</header>
