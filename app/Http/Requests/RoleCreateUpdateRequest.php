<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleCreateUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'alpha', 'unique:roles,name,'.$this->route()->parameter('id')],
            'slug' => ['required', 'string', 'min:3', 'alpha', 'unique:roles,slug,'.$this->route()->parameter('id')],
            'global' => ['required', 'boolean'],
            'globalPermissions' => ['exclude_if:global,false', 'array'],
            'globalPermissions.*' => ['numeric', 'integer', 'exists:permissions,id'],
            'localPermissions' => ['exclude_if:global,true', 'array'],
            'localPermissions.*' => ['numeric', 'integer', 'exists:permissions,id'],
        ];
    }
}
