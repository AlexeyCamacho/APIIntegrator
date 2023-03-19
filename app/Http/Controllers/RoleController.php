<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{
    public function get(Request $request): \Inertia\Response
    {
        return Inertia::render('Admin/Roles',[
            'roles' => Role::all(),
        ]);
    }

    public function create(Request $request): \Inertia\Response
    {
        return Inertia::render('Admin/Role', [
            'permissions' => Permission::all(),
            'categories' => __('categoriesPermissions'),
            'actions' =>  __('actions'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'alpha', 'unique:roles'],
            'slug' => ['required', 'string', 'min:3', 'alpha', 'unique:roles'],
            'global' => ['required', 'boolean'],
            'globalPermissions' => ['exclude_if:global,false', 'array'],
            'globalPermissions.*' => ['numeric', 'integer', 'exists:permissions,id'],
            'localPermissions' => ['exclude_if:global,true', 'array'],
            'localPermissions.*' => ['numeric', 'integer', 'exists:permissions,id'],
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'global' => $validated['global'],
        ]);

        if ($validated['global']) {
            $role->permissions()->sync($validated['globalPermissions']);
        } else {
            $role->permissions()->sync($validated['localPermissions']);
        }

        if ($role) {
            return Redirect::route('role.get');
        } else {
            return back();
        }
    }

    public function destroy(Request $request)
    {

    }
}
