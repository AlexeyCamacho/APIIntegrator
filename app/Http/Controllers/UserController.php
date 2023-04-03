<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function get(Request $request)
    {
        if (!$request->user()->hasPermissionTo('view-user')) {
            return Inertia::render('Errors/Error403');
        }

        return Inertia::render('Admin/Users',[
            'users' => User::with('roles')->get(),
        ]);
    }

    public function show(Request $request)
    {
        if (!$request->user()->hasPermissionTo('view-user')) {
            return Inertia::render('Errors/Error403');
        }

        return Inertia::render('Profile/Profile', [
            'user' => $request->user(),
            'companies' => $request->user()->companiesWithRoleName(),
        ]);
    }
}
