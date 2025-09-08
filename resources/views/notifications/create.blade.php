<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post New Notification') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('notifications.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <x-input-label for="type" :value="__('Type')" />
                                <select id="type" name="type"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Select Type</option>
                                    <option value="marketing" {{ old('type') === 'marketing' ? 'selected' : '' }}>
                                        Marketing</option>
                                    <option value="invoices" {{ old('type') === 'invoices' ? 'selected' : '' }}>Invoices
                                    </option>
                                    <option value="system" {{ old('type') === 'system' ? 'selected' : '' }}>System
                                    </option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('type')" />
                            </div>
                            <div>
                                <x-input-label for="short_text" :value="__('Message')" />
                                <textarea id="short_text" name="short_text" rows="3"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('short_text') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('short_text')" />
                            </div>
                            <div>
                                <x-input-label for="expiration" :value="__('Expiration Date & Time')" />
                                <x-text-input id="expiration" name="expiration" type="date" class="mt-1 block w-full"
                                    :value="old('expiration')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('expiration')" />
                            </div>
                            <div>
                                <x-input-label for="destination" :value="__('Send To')" />
                                <div class="mt-1">
                                    <label class="flex items-center">
                                        <input type="radio" name="destination" value="all"
                                            class="border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                            {{ old('destination') === 'all' ? 'checked' : '' }}
                                            onchange="toggleUserSelect()">
                                        <span class="ml-2">All Users</span>
                                    </label>
                                    <label class="flex items-center mt-2">
                                        <input type="radio" name="destination" value="specific"
                                            class="border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                            {{ old('destination') === 'specific' ? 'checked' : '' }}
                                            onchange="toggleUserSelect()">
                                        <span class="ml-2">Specific User</span>
                                    </label>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('destination')" />
                            </div>
                            <div id="user_select"
                                style="display: {{ old('destination') === 'specific' ? 'block' : 'none' }};">
                                <x-input-label for="user_id" :value="__('Select User')" />
                                <select id="user_id" name="user_id"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <a href="{{ route('notifications.index') }}"
                                    class="bg-gray-500 hover:bg-gray-700 text-white text-sm font-bold py-2 px-4 rounded mr-2">
                                    Cancel
                                </a>
                                <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 text-sm">
                                    {{ __('Post Notification') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleUserSelect() {
            const destination = document.querySelector('input[name="destination"]:checked').value;
            const userSelect = document.getElementById('user_select');
            userSelect.style.display = destination === 'specific' ? 'block' : 'none';
        }
    </script>
</x-app-layout>
