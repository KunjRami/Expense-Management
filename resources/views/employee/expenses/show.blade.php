<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Expense Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Employee</h3>
                            <p class="mt-1">{{ $expense->user->name }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Expense Date</h3>
                            <p class="mt-1">{{ $expense->expense_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Category</h3>
                            <p class="mt-1">{{ $expense->category }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Status</h3>
                            <p class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($expense->status === 'Approved') bg-green-100 text-green-800
                                    @elseif($expense->status === 'Rejected') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ $expense->status }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Amount</h3>
                            <p class="mt-1">{{ $expense->currency }} {{ number_format($expense->amount, 2) }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Converted Amount ({{ auth()->user()->company->currency }})</h3>
                            <p class="mt-1">{{ auth()->user()->company->currency }} {{ number_format($expense->converted_amount, 2) }}</p>
                        </div>
                    </div>

                    @if($expense->description)
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-500">Description</h3>
                            <p class="mt-1">{{ $expense->description }}</p>
                        </div>
                    @endif

                    @if($expense->receipt_path)
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Receipt</h3>
                            <a href="{{ asset('storage/' . $expense->receipt_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                                View Receipt
                            </a>
                        </div>
                    @endif

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Approval History</h3>
                        @forelse($expense->approvals as $approval)
                            <div class="border-l-4 @if($approval->status === 'Approved') border-green-500 @elseif($approval->status === 'Rejected') border-red-500 @else border-yellow-500 @endif pl-4 mb-4">
                                <div class="flex justify-between">
                                    <div>
                                        <p class="font-medium">{{ $approval->approver->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $approval->approver->role }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($approval->status === 'Approved') bg-green-100 text-green-800
                                            @elseif($approval->status === 'Rejected') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ $approval->status }}
                                        </span>
                                        <p class="text-xs text-gray-500 mt-1">{{ $approval->updated_at->format('M d, Y H:i') }}</p>
                                    </div>
                                </div>
                                @if($approval->comments)
                                    <p class="text-sm text-gray-600 mt-2">Comments: {{ $approval->comments }}</p>
                                @endif
                            </div>
                        @empty
                            <p class="text-gray-500">No approval history yet.</p>
                        @endforelse
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('employee.expenses.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
