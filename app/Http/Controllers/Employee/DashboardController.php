<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'total_expenses' => Expense::where('user_id', $user->id)->count(),
            'pending_expenses' => Expense::where('user_id', $user->id)->where('status', 'Pending')->count(),
            'approved_expenses' => Expense::where('user_id', $user->id)->where('status', 'Approved')->count(),
            'rejected_expenses' => Expense::where('user_id', $user->id)->where('status', 'Rejected')->count(),
            'total_amount' => Expense::where('user_id', $user->id)->where('status', 'Approved')->sum('converted_amount'),
        ];
        
        $recentExpenses = Expense::where('user_id', $user->id)
            ->with('approvals.approver')
            ->latest()
            ->take(5)
            ->get();
        
        return view('employee.dashboard', compact('stats', 'recentExpenses'));
    }
}
