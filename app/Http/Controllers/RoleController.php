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
use Inertia\Response;

class RoleController extends Controller
{
    public function get(Request $request): Response
    {
        if (!Gate::allows('view-role')) {
            return Inertia::render('Errors/Error403');
        }

        return Inertia::render('Admin/Roles',[
            'roles' => Role::all(),
        ]);
    }

    public function create(Request $request): Response
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

    public function store(RoleCreateUpdateRequest $request): Response|RedirectResponse
    {
        if (!Gate::allows('create-role')) {
            return Inertia::render('Errors/Error403');
        }

        return $this->updateOrCreate($request);
    }

    public function edit(Request $request, $id): Response
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

    public function update(RoleCreateUpdateRequest $request, $id): Response|RedirectResponse
    {
        if (!Gate::allows('edit-role')) {
            return Inertia::render('Errors/Error403');
        }

        return $this->updateOrCreate($request, $id);
    }

    private function updateOrCreate(RoleCreateUpdateRequest $request, $id = -1): RedirectResponse
    {
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

    public function destroy(Request $request): bool|Response
    {
        if (!Gate::allows('delete-role')) {
            return Inertia::render('Errors/Error403');
        }

        $validated = $request->validate([
            'id' => ['required', 'integer', 'numeric', 'exists:roles'],
        ]);

        Role::destroy($validated['id']);

        return true;
    }
}
