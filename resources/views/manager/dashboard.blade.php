<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manager Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-sm text-gray-600">Pending Approvals</div>
                        <div class="text-3xl font-bold text-yellow-600">{{ $stats['pending_approvals'] }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-sm text-gray-600">Approved</div>
                        <div class="text-3xl font-bold text-green-600">{{ $stats['approved_count'] }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-sm text-gray-600">Rejected</div>
                        <div class="text-3xl font-bold text-red-600">{{ $stats['rejected_count'] }}</div>
                    </div>
                </div>
            </div>

            <!-- Pending Approvals -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Pending Approvals</h3>
                    @forelse($pendingApprovals as $approval)
                        <div class="border rounded-lg p-4 mb-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium">{{ $approval->expense->user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $approval->expense->category }} - {{ $approval->expense->expense_date->format('M d, Y') }}</p>
                                    <p class="text-lg font-bold mt-2">{{ auth()->user()->company->currency }} {{ number_format($approval->expense->converted_amount, 2) }}</p>
                                    @if($approval->expense->description)
                                        <p class="text-sm text-gray-600 mt-2">{{ $approval->expense->description }}</p>
                                    @endif
                                </div>
                                <div class="flex gap-2">
                                    <form action="{{ route('manager.approvals.approve', $approval) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                            Approve
                                        </button>
                                    </form>
                                    <button onclick="openRejectModal({{ $approval->id }})" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                        Reject
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">No pending approvals.</p>
                    @endforelse
                </div>
            </div>

            <!-- Team Expenses -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Recent Team Expenses</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($teamExpenses as $expense)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $expense->user->name }}</td>
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
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No team expenses yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Reject Expense</h3>
                <form id="rejectForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Comments (Required)</label>
                        <textarea name="comments" rows="4" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            Reject
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRejectModal(approvalId) {
            document.getElementById('rejectModal').classList.remove('hidden');
            document.getElementById('rejectForm').action = `/manager/approvals/${approvalId}/reject`;
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
