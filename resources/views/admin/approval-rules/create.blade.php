<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Approval Rule') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.approval-rules.store') }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="rule_type" :value="__('Rule Type')" />
                            <select id="rule_type" name="rule_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required onchange="toggleRuleFields()">
                                <option value="">Select Rule Type</option>
                                <option value="percentage" {{ old('rule_type') === 'percentage' ? 'selected' : '' }}>Percentage</option>
                                <option value="specific" {{ old('rule_type') === 'specific' ? 'selected' : '' }}>Specific Approver</option>
                                <option value="hybrid" {{ old('rule_type') === 'hybrid' ? 'selected' : '' }}>Hybrid (Percentage OR Specific)</option>
                            </select>
                            <x-input-error :messages="$errors->get('rule_type')" class="mt-2" />
                        </div>

                        <div id="percentage_field" class="mb-4" style="display: none;">
                            <x-input-label for="percentage" :value="__('Required Approval Percentage')" />
                            <x-text-input id="percentage" class="block mt-1 w-full" type="number" name="percentage" :value="old('percentage')" min="1" max="100" />
                            <p class="text-sm text-gray-500 mt-1">Enter a value between 1 and 100</p>
                            <x-input-error :messages="$errors->get('percentage')" class="mt-2" />
                        </div>

                        <div id="specific_user_field" class="mb-4" style="display: none;">
                            <x-input-label for="specific_user_id" :value="__('Specific Approver')" />
                            <select id="specific_user_id" name="specific_user_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Select Approver</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('specific_user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->role }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('specific_user_id')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.approval-rules.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 mr-2">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Create Rule') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleRuleFields() {
            const ruleType = document.getElementById('rule_type').value;
            const percentageField = document.getElementById('percentage_field');
            const specificUserField = document.getElementById('specific_user_field');
            
            percentageField.style.display = 'none';
            specificUserField.style.display = 'none';
            
            if (ruleType === 'percentage' || ruleType === 'hybrid') {
                percentageField.style.display = 'block';
            }
            
            if (ruleType === 'specific' || ruleType === 'hybrid') {
                specificUserField.style.display = 'block';
            }
        }

        // Show fields on page load if there are old values
        document.addEventListener('DOMContentLoaded', function() {
            toggleRuleFields();
        });
    </script>
</x-app-layout>
