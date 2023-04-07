<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Models\Role;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function get(Request $request): Response
    {
        if (!$request->user()->hasPermissionTo('view-user')) {
            return Inertia::render('Errors/Error403');
        }

        return Inertia::render('Admin/Users',[
            'users' => User::with('roles')->get(),
        ]);
    }

    public function show(Request $request, $id): Response
    {
        if (!$request->user()->hasPermissionTo('view-user')) {
            return Inertia::render('Errors/Error403');
        }

        $user = User::find($id);

        return Inertia::render('Profile/Profile', [
            'user' => $user,
            'companies' => $user->companiesWithRoleName(),
        ]);
    }

    public function create(Request $request): Response
    {
        if (!$request->user()->hasPermissionTo('create-user')) {
            return Inertia::render('Errors/Error403');
        }

        return Inertia::render('Admin/User', [
            'globalRoles' => Role::where('global', 1)->get(),
            'localRoles' => Role::where('global', 0)->get(),
            'companies' => Company::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): Response|RedirectResponse
    {
        if (!$request->user()->hasPermissionTo('create-user')) {
            return Inertia::render('Errors/Error403');
        }

        $validated = $request->validate([
            'login' => ['required', 'string', 'min:3', 'unique:users,name'],
            'email' => ['required', 'string', 'unique:users,email'],
            'role' => ['required'],
        ]);

        $user = User::updateOrCreate(
            ['id' => -1],
            ['name' => $validated['login'], 'email' => $validated['email'], 'password' => Hash::make(Str::random(10))]
        );

        $user->roles()->sync($validated['role']);

        return Redirect::route('user.get');
    }
}
