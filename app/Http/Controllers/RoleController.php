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
        if (!$request->user()->hasPermissionTo('view-role')) {
            return Inertia::render('Errors/Error403');
        }

        return Inertia::render('Admin/Roles',[
            'roles' => Role::all(),
        ]);
    }

    public function create(Request $request): \Inertia\Response
    {
        if (!$request->user()->hasPermissionTo('create-role')) {
            return Inertia::render('Errors/Error403');
        }

        return Inertia::render('Admin/Role', [
            'permissions' => Permission::all(),
            'categories' => __('categoriesPermissions'),
            'actions' =>  __('actions'),
        ]);
    }

    public function store(Request $request)
    {
        if (!$request->user()->hasPermissionTo('create-role')) {
            return Inertia::render('Errors/Error403');
        }

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

        return Redirect::route('role.get');
    }

    public function edit(Request $request, $id)
    {
        if (!$request->user()->hasPermissionTo('edit-role')) {
            return Inertia::render('Errors/Error403');
        }

        $role = Role::find($id);

        return Inertia::render('Admin/Role', [
            'permissions' => Permission::all(),
            'categories' => __('categoriesPermissions'),
            'actions' =>  __('actions'),
            'role' => $role,
            'rolePermissions' => $role->permissions()->pluck('id')
        ]);
    }

    public function update(Request $request, $id)
    {
        if (!$request->user()->hasPermissionTo('edit-role')) {
            return Inertia::render('Errors/Error403');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'alpha', 'unique:roles,name,'.$id],
            'slug' => ['required', 'string', 'min:3', 'alpha', 'unique:roles,slug,'.$id],
            'global' => ['required', 'boolean'],
            'globalPermissions' => ['exclude_if:global,false', 'array'],
            'globalPermissions.*' => ['numeric', 'integer', 'exists:permissions,id'],
            'localPermissions' => ['exclude_if:global,true', 'array'],
            'localPermissions.*' => ['numeric', 'integer', 'exists:permissions,id'],
        ]);

        $role = Role::find($id);

        $role->fill([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'global' => $validated['global'],
        ]);

        $role->save();

        if ($validated['global']) {
            $role->permissions()->sync($validated['globalPermissions']);
        } else {
            $role->permissions()->sync($validated['localPermissions']);
        }

        return Redirect::route('role.get');
    }

    public function destroy(Request $request)
    {
        if (!$request->user()->hasPermissionTo('delete-role')) {
            return Inertia::render('Errors/Error403');
        }

        $validated = $request->validate([
            'id' => ['required', 'integer', 'numeric', 'exists:roles'],
        ]);

        Role::destroy($validated['id']);
    }
}
