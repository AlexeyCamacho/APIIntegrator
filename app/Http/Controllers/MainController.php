<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class MainController extends Controller
{
    public function show(Request $request): \Inertia\Response
    {
        $companiesPermissions = collect();
        $companies = $request->user()->companies()->get();

        foreach ($companies as $company) {
            $tmp = collect($company->toArray());
            $tmp = $tmp->merge(['permissions' => $company->roles()->first()->permissions()->pluck('slug')->toArray()]);
            $companiesPermissions->push($tmp);
        }

        return Inertia::render('Dashboard',[
            'companies' => Gate::allows('view-company-admin') ? Company::all() : $companiesPermissions,
        ]);
    }
}
