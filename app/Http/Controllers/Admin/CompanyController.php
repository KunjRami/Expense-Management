<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $company = auth()->user()->company;
        
        return view('admin.company.index', compact('company'));
    }

    public function update(Request $request)
    {
        $company = auth()->user()->company;

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'currency' => ['required', 'string', 'size:3'],
        ]);

        $company->update([
            'name' => $request->name,
            'currency' => strtoupper($request->currency),
        ]);

        return redirect()->route('admin.company.index')->with('success', 'Company settings updated successfully.');
    }
}
