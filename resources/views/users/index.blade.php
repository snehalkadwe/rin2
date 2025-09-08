<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users Management') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="w-full divide-y divide-gray-200 border-collapse border border-gray-200">
                            <thead class="bg-gray-50 text-left">
                                <tr>
                                    <th
                                        class="p-4 text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200">
                                        Name
                                    </th>
                                    <th
                                        class="p-4 text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200 w-1/3">
                                        Email
                                    </th>
                                    <th
                                        class="p-4 text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200">
                                        Phone
                                    </th>
                                    <th
                                        class="p-4 text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200">
                                        Notifications
                                    </th>
                                    <th
                                        class="p-4 text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200 w-16 text-center">
                                        Unread
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($users as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border border-gray-200">
                                            @if (auth()->user()->canImpersonate() && auth()->id() !== $user->id)
                                                <a href="{{ route('users.impersonate', $user) }}"
                                                    class="text-indigo-600 hover:text-indigo-900">
                                                    {{ $user->name }}
                                                </a>
                                            @else
                                                {{ $user->name }}
                                            @endif
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border border-gray-200 break-words">
                                            {{ $user->email }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border border-gray-200">
                                            {{ $user->phone_number ?: 'N/A' }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border border-gray-200">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->notification_switch ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $user->notification_switch ? 'Enabled' : 'Disabled' }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border border-gray-200 text-center">
                                            <span
                                                class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                                {{ $user->unreadNotifications->count() }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
