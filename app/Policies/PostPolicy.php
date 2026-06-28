<?php

namespace App\Policies;

use App\Models\User;

/**
 * Reglas de autorización para la gestión de entradas del blog.
 */
class PostPolicy
{
    /**
     * Determina si el usuario puede ver el listado de entradas.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede crear entradas.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede editar entradas.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede eliminar entradas.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede restaurar entradas eliminadas.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function restore(User $user): bool
    {
        return $user->isAdmin();
    }
}
