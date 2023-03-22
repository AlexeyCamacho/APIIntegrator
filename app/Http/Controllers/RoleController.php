<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleCreateUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{
    public function get(Request $request): \Inertia\Response
    {
        if (!Gate::allows('view-role')) {
            return Inertia::render('Errors/Error403');
        }

        return Inertia::render('Admin/Roles',[
            'roles' => Role::all(),
        ]);
    }

    public function create(Request $request): \Inertia\Response
    {
        if (!Gate::allows('create-role')) {
            return Inertia::render('Errors/Error403');
        }

        return Inertia::render('Admin/Role', [
            'permissions' => Permission::all(),
            'categories' => __('categoriesPermissions'),
            'actions' =>  __('actions'),
        ]);
    }

    public function store(RoleCreateUpdateRequest $request): \Inertia\Response|RedirectResponse
    {
        if (!Gate::allows('create-role')) {
            return Inertia::render('Errors/Error403');
        }

        $validated = $request->validated();

        $role = Role::updateOrCreate(
            ['id' => -1],
            ['name' => $validated['name'], 'slug' => $validated['slug'], 'global' => $validated['global']]
        );

        if ($validated['global']) {
            $role->permissions()->sync($validated['globalPermissions']);
        } else {
            $role->permissions()->sync($validated['localPermissions']);
        }

        return Redirect::route('role.get');
    }

    public function edit(Request $request, $id): \Inertia\Response
    {
        if (!Gate::allows('edit-role')) {
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

    public function update(RoleCreateUpdateRequest $request, $id): \Inertia\Response|RedirectResponse
    {
        if (!Gate::allows('edit-role')) {
            return Inertia::render('Errors/Error403');
        }

        $validated = $request->validated();

        $role = Role::updateOrCreate(
            ['id' => $id],
            ['name' => $validated['name'], 'slug' => $validated['slug'], 'global' => $validated['global']]
        );

        if ($validated['global']) {
            $role->permissions()->sync($validated['globalPermissions']);
        } else {
            $role->permissions()->sync($validated['localPermissions']);
        }

        return Redirect::route('role.get');
    }

    public function destroy(Request $request)
    {
        if (!Gate::allows('delete-role')) {
            return Inertia::render('Errors/Error403');
        }

        $validated = $request->validate([
            'id' => ['required', 'integer', 'numeric', 'exists:roles'],
        ]);

        Role::destroy($validated['id']);
    }
}
