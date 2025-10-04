<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submit New Expense') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('employee.expenses.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="expense_date" :value="__('Expense Date')" />
                            <x-text-input id="expense_date" class="block mt-1 w-full" type="date" name="expense_date" :value="old('expense_date', date('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('expense_date')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="category" :value="__('Category')" />
                            <select id="category" name="category" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Category</option>
                                <option value="Travel" {{ old('category') === 'Travel' ? 'selected' : '' }}>Travel</option>
                                <option value="Food" {{ old('category') === 'Food' ? 'selected' : '' }}>Food</option>
                                <option value="Accommodation" {{ old('category') === 'Accommodation' ? 'selected' : '' }}>Accommodation</option>
                                <option value="Office Supplies" {{ old('category') === 'Office Supplies' ? 'selected' : '' }}>Office Supplies</option>
                                <option value="Equipment" {{ old('category') === 'Equipment' ? 'selected' : '' }}>Equipment</option>
                                <option value="Other" {{ old('category') === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="amount" :value="__('Amount')" />
                                <x-text-input id="amount" class="block mt-1 w-full" type="number" step="0.01" name="amount" :value="old('amount')" required />
                                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="currency" :value="__('Currency')" />
                                <x-text-input id="currency" class="block mt-1 w-full" type="text" name="currency" :value="old('currency', auth()->user()->company->currency)" required maxlength="3" />
                                <x-input-error :messages="$errors->get('currency')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="receipt" :value="__('Receipt (Optional)')" />
                            <input id="receipt" type="file" name="receipt" accept=".jpg,.jpeg,.png,.pdf" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
                            <p class="text-sm text-gray-500 mt-1">Accepted formats: JPG, PNG, PDF (Max: 2MB)</p>
                            <x-input-error :messages="$errors->get('receipt')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('employee.expenses.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 mr-2">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Submit Expense') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
