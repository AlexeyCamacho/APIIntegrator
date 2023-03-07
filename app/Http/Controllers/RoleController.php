<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

class RoleController extends Controller
{
    public function get(Request $request)
    {
        //dd($request->route());
        return Inertia::render('Admin/Roles',[
            'roles' => Role::all(),
        ]);
    }
}
