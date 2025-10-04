<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Approval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $expenses = Expense::with(['user', 'approvals.approver'])->latest()->paginate(10);
        } else {
            $expenses = Expense::where('user_id', $user->id)->with(['approvals.approver'])->latest()->paginate(10);
        }
        
        return view('employee.expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('employee.expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            'currency' => ['required', 'string', 'size:3'],
            'category' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'expense_date' => ['required', 'date'],
            'receipt' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')->store('receipts', 'public');
        }

        $user = auth()->user();
        $companyCurrency = $user->company->currency;
        
        // For now, set converted_amount equal to amount. We'll add API conversion later
        $convertedAmount = $request->amount;
        if (strtoupper($request->currency) !== $companyCurrency) {
            // TODO: Implement currency conversion API
            $convertedAmount = $request->amount;
        }

        $expense = Expense::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'currency' => strtoupper($request->currency),
            'converted_amount' => $convertedAmount,
            'category' => $request->category,
            'description' => $request->description,
            'expense_date' => $request->expense_date,
            'receipt_path' => $receiptPath,
        ]);

        // Create approval workflow
        if ($user->manager_id) {
            Approval::create([
                'expense_id' => $expense->id,
                'approver_id' => $user->manager_id,
                'sequence' => 1,
                'is_manager_approver' => true,
            ]);
        }

        return redirect()->route('employee.expenses.index')->with('success', 'Expense submitted successfully.');
    }

    public function show(Expense $expense)
    {
        $user = auth()->user();
        
        if ($expense->user_id !== $user->id && !$user->isAdmin()) {
            abort(403);
        }
        
        $expense->load(['user', 'approvals.approver']);
        
        return view('employee.expenses.show', compact('expense'));
    }
}
