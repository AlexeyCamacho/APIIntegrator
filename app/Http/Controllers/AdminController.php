<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Permission;

class AdminController extends Controller
{
    public function view(Request $request)
    {
        $user = $request->user();
        dd($user->giveRoleTo(null, 'admin'));
    }
}
