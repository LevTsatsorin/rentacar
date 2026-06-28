<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

/**
 * Gestiona la administración de usuarios.
 */
class AdminUserController extends Controller
{
    /**
     * Lista los usuarios con el conteo de sus reservas, paginados.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $users = User::withCount('bookings')->orderBy('name')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Muestra el detalle de un usuario con sus reservas y autos.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function show(User $user): View
    {
        $user->load('bookings.car');

        return view('admin.users.show', compact('user'));
    }
}
