<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Expense;
use App\Models\Company;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $company = $user->company;
        
        $stats = [
            'total_users' => User::where('company_id', $company->id)->count(),
            'total_expenses' => Expense::whereHas('user', function($q) use ($company) {
                $q->where('company_id', $company->id);
            })->count(),
            'pending_expenses' => Expense::whereHas('user', function($q) use ($company) {
                $q->where('company_id', $company->id);
            })->where('status', 'Pending')->count(),
            'approved_expenses' => Expense::whereHas('user', function($q) use ($company) {
                $q->where('company_id', $company->id);
            })->where('status', 'Approved')->count(),
            'total_amount' => Expense::whereHas('user', function($q) use ($company) {
                $q->where('company_id', $company->id);
            })->where('status', 'Approved')->sum('converted_amount'),
        ];
        
        return view('admin.dashboard', compact('stats', 'company'));
    }
}
