<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // Admins should see all pending approvals (site-wide). Managers see approvals assigned to them.
        if ($user->isAdmin()) {
            $approvals = Approval::where('status', 'Pending')
                ->with(['expense.user'])
                ->paginate(10);
        } else {
            $approvals = Approval::where('approver_id', $user->id)
                ->where('status', 'Pending')
                ->with(['expense.user'])
                ->paginate(10);
        }
        
        return view('manager.approvals.index', compact('approvals'));
    }

    public function approve(Request $request, Approval $approval)
    {
        // Allow the assigned approver or an Admin to approve
        if ($approval->approver_id !== auth()->id() && ! auth()->user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'comments' => ['nullable', 'string'],
        ]);

        $approval->update([
            'status' => 'Approved',
            'comments' => $request->comments,
        ]);

        // Update expense status
        $expense = $approval->expense;
        $pendingApprovals = $expense->approvals()->where('status', 'Pending')->count();
        
        if ($pendingApprovals === 0) {
            $expense->update(['status' => 'Approved']);
        }

        return redirect()->route('manager.approvals.index')->with('success', 'Expense approved successfully.');
    }

    public function reject(Request $request, Approval $approval)
    {
        // Allow the assigned approver or an Admin to reject
        if ($approval->approver_id !== auth()->id() && ! auth()->user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'comments' => ['required', 'string'],
        ]);

        $approval->update([
            'status' => 'Rejected',
            'comments' => $request->comments,
        ]);

        // Update expense status
        $approval->expense->update(['status' => 'Rejected']);

        return redirect()->route('manager.approvals.index')->with('success', 'Expense rejected.');
    }

    public function history()
    {
        $user = auth()->user();
        
        $approvals = Approval::where('approver_id', $user->id)
            ->whereIn('status', ['Approved', 'Rejected'])
            ->with(['expense.user'])
            ->latest()
            ->paginate(10);
        
        return view('manager.approvals.history', compact('approvals'));
    }
}
