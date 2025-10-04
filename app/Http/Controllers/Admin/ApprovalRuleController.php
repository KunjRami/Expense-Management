<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApprovalRule;
use App\Models\User;
use Illuminate\Http\Request;

class ApprovalRuleController extends Controller
{
    public function index()
    {
        $company = auth()->user()->company;
        $rules = ApprovalRule::where('company_id', $company->id)
            ->with('specificUser')
            ->get();
        
        return view('admin.approval-rules.index', compact('rules'));
    }

    public function create()
    {
        $company = auth()->user()->company;
        $users = User::where('company_id', $company->id)
            ->whereIn('role', ['Admin', 'Manager'])
            ->get();
        
        return view('admin.approval-rules.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rule_type' => ['required', 'in:percentage,specific,hybrid'],
            'percentage' => ['required_if:rule_type,percentage,hybrid', 'nullable', 'integer', 'min:1', 'max:100'],
            'specific_user_id' => ['required_if:rule_type,specific,hybrid', 'nullable', 'exists:users,id'],
        ]);

        ApprovalRule::create([
            'company_id' => auth()->user()->company_id,
            'rule_type' => $request->rule_type,
            'percentage' => $request->percentage,
            'specific_user_id' => $request->specific_user_id,
        ]);

        return redirect()->route('admin.approval-rules.index')->with('success', 'Approval rule created successfully.');
    }

    public function destroy(ApprovalRule $approvalRule)
    {
        $company = auth()->user()->company;
        
        if ($approvalRule->company_id !== $company->id) {
            abort(403);
        }

        $approvalRule->delete();

        return redirect()->route('admin.approval-rules.index')->with('success', 'Approval rule deleted successfully.');
    }
}
