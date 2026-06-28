<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

/**
 * Valida los datos para la actualización de un post del blog.
 */
class UpdatePostRequest extends StorePostRequest
{
    /**
     * Reglas de validación aplicadas a la actualización del post.
     *
     * @return array
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'slug' => ['required', 'string', 'max:255', Rule::unique('posts', 'slug')->ignore($this->route('post'))],
        ]);
    }
}
