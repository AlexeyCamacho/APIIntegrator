<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function view(Request $request): \Inertia\Response
    {
        if (!Gate::allows('view-admin-panel')) {
            return Inertia::render('Errors/Error403');
        }

         return Inertia::render('Admin/AdminPanel');
    }
}
