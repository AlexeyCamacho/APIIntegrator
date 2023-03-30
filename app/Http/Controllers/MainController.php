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
        $companies = $request->user()->companies()->get();
        $companiesPermissions = $this->getPermForCompanies($companies);

        return Inertia::render('Dashboard',[
            'companies' => Gate::allows('view-company-admin') ? $this->getPermForCompanies(Company::all()) : $companiesPermissions,
        ]);
    }

    private function getPermForCompanies($companies) {
        $companiesPermissions = collect();

        foreach ($companies as $company) {
            $tmp = collect($company->toArray());
            if ($company->roles()->count()) {
                $tmp = $tmp->merge(['permissions' => $company->roles()->first()->permissions()->pluck('slug')->toArray()]);
            } else {
                $tmp = $tmp->merge(['permissions' => '']);
            }
            $companiesPermissions->push($tmp);
        }
        return $companiesPermissions;
    }
}
