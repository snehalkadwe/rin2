<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notification Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user.settings.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text"
                                    class="mt-1 block w-full hide" :value="old('name', auth()->user()->name)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                    :value="old('email', auth()->user()->email)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <x-input-label for="phone_number" :value="__('Phone Number')" />
                                <x-text-input id="phone_number" name="phone_number" type="tel"
                                    class="mt-1 block w-full" :value="old('phone_number', auth()->user()->phone_number)" placeholder="+1234567890" />
                                <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
                                <p class="mt-1 text-sm text-gray-500">Enter your phone number with country code (e.g.,
                                    +1234567890)</p>
                            </div>

                            <!-- Notification Switch -->
                            <div>
                                <!-- Hidden input ensures 0 is always sent if unchecked -->
                                <input type="hidden" name="notification_switch" value="0">

                                <label for="notification_switch"
                                    class="relative inline-flex items-center cursor-pointer">
                                    <!-- Checkbox toggle -->
                                    <input id="notification_switch" name="notification_switch" type="checkbox"
                                        value="1" class="sr-only peer"
                                        {{ old('notification_switch', auth()->user()->notification_switch) ? 'checked' : '' }}>
                                    <div
                                        class="w-12 h-6 bg-gray-300 rounded-full peer-checked:bg-indigo-600
                                        transition-colors duration-300 ease-in-out">
                                    </div>
                                    <div
                                        class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full shadow-md
                                        peer-checked:translate-x-6 transform transition-transform duration-300 ease-in-out">
                                    </div>
                                    <span class="ml-3 text-sm text-gray-600">
                                        {{ __('Enable on-screen notifications') }}
                                    </span>
                                </label>

                                <x-input-error class="mt-2" :messages="$errors->get('notification_switch')" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button>
                                    {{ __('Update Settings') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
