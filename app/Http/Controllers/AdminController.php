<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function view(Request $request): \Inertia\Response
    {
         Gate::allows('view-company');

         return Inertia::render('Admin/AdminPanel');
    }
}
