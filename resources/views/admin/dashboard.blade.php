<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-sm text-gray-600">Total Users</div>
                        <div class="text-3xl font-bold">{{ $stats['total_users'] }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-sm text-gray-600">Total Expenses</div>
                        <div class="text-3xl font-bold">{{ $stats['total_expenses'] }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-sm text-gray-600">Pending Approvals</div>
                        <div class="text-3xl font-bold text-yellow-600">{{ $stats['pending_expenses'] }}</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-sm text-gray-600">Approved Expenses</div>
                        <div class="text-3xl font-bold text-green-600">{{ $stats['approved_expenses'] }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-sm text-gray-600">Total Amount ({{ $company->currency }})</div>
                        <div class="text-3xl font-bold">{{ number_format($stats['total_amount'], 2) }}</div>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('admin.users.index') }}" class="text-center p-4 border rounded-lg hover:bg-gray-50">
                            <div class="text-2xl mb-2">👥</div>
                            <div class="text-sm font-medium">Manage Users</div>
                        </a>
                        <a href="{{ route('admin.company.index') }}" class="text-center p-4 border rounded-lg hover:bg-gray-50">
                            <div class="text-2xl mb-2">🏢</div>
                            <div class="text-sm font-medium">Company Settings</div>
                        </a>
                        <a href="{{ route('admin.approval-rules.index') }}" class="text-center p-4 border rounded-lg hover:bg-gray-50">
                            <div class="text-2xl mb-2">⚙️</div>
                            <div class="text-sm font-medium">Approval Rules</div>
                        </a>
                        <a href="{{ route('employee.expenses.index') }}" class="text-center p-4 border rounded-lg hover:bg-gray-50">
                            <div class="text-2xl mb-2">💰</div>
                            <div class="text-sm font-medium">All Expenses</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
