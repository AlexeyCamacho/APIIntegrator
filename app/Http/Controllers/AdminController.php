<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;
use Inertia\Response;

class AdminController extends Controller
{
    public function view(Request $request): Response
    {
        if (!Gate::allows('view-admin-panel')) {
            return Inertia::render('Errors/Error403');
        }

         return Inertia::render('Admin/AdminPanel');
    }
}
