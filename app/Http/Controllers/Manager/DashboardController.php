<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use App\Models\Expense;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $pendingApprovals = Approval::where('approver_id', $user->id)
            ->where('status', 'Pending')
            ->with(['expense.user'])
            ->get();
        
        $stats = [
            'pending_approvals' => $pendingApprovals->count(),
            'approved_count' => Approval::where('approver_id', $user->id)->where('status', 'Approved')->count(),
            'rejected_count' => Approval::where('approver_id', $user->id)->where('status', 'Rejected')->count(),
        ];
        
        $teamExpenses = Expense::whereHas('user', function($q) use ($user) {
            $q->where('manager_id', $user->id);
        })->with('user')->latest()->take(10)->get();
        
        return view('manager.dashboard', compact('stats', 'pendingApprovals', 'teamExpenses'));
    }
}
