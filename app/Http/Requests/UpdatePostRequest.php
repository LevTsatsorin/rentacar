<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdatePostRequest extends StorePostRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'slug' => ['required', 'string', 'max:255', Rule::unique('posts', 'slug')->ignore($this->route('post'))],
        ]);
    }
}
