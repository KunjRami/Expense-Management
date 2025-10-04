<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Expenses') }}
            </h2>
            <a href="{{ route('employee.expenses.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Submit New Expense
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Converted</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                @if(auth()->user()->isAdmin())
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                                @endif
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($expenses as $expense)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $expense->expense_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $expense->category }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $expense->currency }} {{ number_format($expense->amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ auth()->user()->company->currency }} {{ number_format($expense->converted_amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($expense->status === 'Approved') bg-green-100 text-green-800
                                            @elseif($expense->status === 'Rejected') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ $expense->status }}
                                        </span>
                                    </td>
                                    @if(auth()->user()->isAdmin())
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $expense->user->name }}</td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('employee.expenses.show', $expense) }}" class="text-indigo-600 hover:text-indigo-900">View Details</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->isAdmin() ? '7' : '6' }}" class="px-6 py-4 text-center text-gray-500">No expenses found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $expenses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
