<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Permission;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function view(Request $request): \Inertia\Response
    {
         return Inertia::render('Admin/AdminPanel');
    }
}
