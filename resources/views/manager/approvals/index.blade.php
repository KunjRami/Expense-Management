<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pending Approvals') }}
        </h2>
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
                    @forelse($approvals as $approval)
                        <div class="border rounded-lg p-6 mb-4">
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Employee</h3>
                                    <p class="mt-1 font-medium">{{ $approval->expense->user->name }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Expense Date</h3>
                                    <p class="mt-1">{{ $approval->expense->expense_date->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Category</h3>
                                    <p class="mt-1">{{ $approval->expense->category }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Amount</h3>
                                    <p class="mt-1 text-lg font-bold">{{ auth()->user()->company->currency }} {{ number_format($approval->expense->converted_amount, 2) }}</p>
                                </div>
                            </div>

                            @if($approval->expense->description)
                                <div class="mb-4">
                                    <h3 class="text-sm font-medium text-gray-500">Description</h3>
                                    <p class="mt-1">{{ $approval->expense->description }}</p>
                                </div>
                            @endif

                            @if($approval->expense->receipt_path)
                                <div class="mb-4">
                                    <a href="{{ asset('storage/' . $approval->expense->receipt_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                                        View Receipt
                                    </a>
                                </div>
                            @endif

                            <div class="flex gap-2 mt-4">
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
                    @empty
                        <p class="text-gray-500 text-center py-8">No pending approvals.</p>
                    @endforelse

                    <div class="mt-4">
                        {{ $approvals->links() }}
                    </div>
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
