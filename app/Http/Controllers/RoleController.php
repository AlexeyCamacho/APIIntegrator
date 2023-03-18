<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            'name' => ['required', 'string', 'min:3', 'alpha'],
            'slug' => ['required', 'string', 'min:3', 'alpha'],
            'permissions' => ['array'],
            'permissions.*' => ['numeric', 'integer']
        ]);

        return back();
    }
}
