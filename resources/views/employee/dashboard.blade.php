<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employee Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-sm text-gray-600">Total Expenses</div>
                        <div class="text-3xl font-bold">{{ $stats['total_expenses'] }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-sm text-gray-600">Pending</div>
                        <div class="text-3xl font-bold text-yellow-600">{{ $stats['pending_expenses'] }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-sm text-gray-600">Approved</div>
                        <div class="text-3xl font-bold text-green-600">{{ $stats['approved_expenses'] }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-sm text-gray-600">Rejected</div>
                        <div class="text-3xl font-bold text-red-600">{{ $stats['rejected_expenses'] }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="text-sm text-gray-600">Total Approved Amount</div>
                    <div class="text-3xl font-bold">{{ auth()->user()->company->currency }} {{ number_format($stats['total_amount'], 2) }}</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('employee.expenses.create') }}" class="text-center p-4 border rounded-lg hover:bg-gray-50">
                            <div class="text-2xl mb-2">➕</div>
                            <div class="text-sm font-medium">Submit Expense</div>
                        </a>
                        <a href="{{ route('employee.expenses.index') }}" class="text-center p-4 border rounded-lg hover:bg-gray-50">
                            <div class="text-2xl mb-2">📋</div>
                            <div class="text-sm font-medium">My Expenses</div>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="text-center p-4 border rounded-lg hover:bg-gray-50">
                            <div class="text-2xl mb-2">⚙️</div>
                            <div class="text-sm font-medium">Profile Settings</div>
                        </a>
                        @if(auth()->user()->manager)
                            <div class="text-center p-4 border rounded-lg bg-gray-50">
                                <div class="text-2xl mb-2">👤</div>
                                <div class="text-sm font-medium">Manager: {{ auth()->user()->manager->name }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Expenses -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Recent Expenses</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentExpenses as $expense)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $expense->expense_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $expense->category }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $expense->currency }} {{ number_format($expense->amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($expense->status === 'Approved') bg-green-100 text-green-800
                                            @elseif($expense->status === 'Rejected') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ $expense->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No expenses yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
