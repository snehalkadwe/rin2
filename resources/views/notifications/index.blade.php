<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Notifications Management') }}
            </h2>
            <a href="{{ route('notifications.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                Post New Notification
            </a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('notifications.index') }}" class="flex gap-4">
                        <div>
                            <select name="type" class="border-gray-300 rounded-md shadow-sm text-sm">
                                <option value="">All Types</option>
                                <option value="marketing" {{ request('type') === 'marketing' ? 'selected' : '' }}>
                                    Marketing</option>
                                <option value="invoices" {{ request('type') === 'invoices' ? 'selected' : '' }}>Invoices
                                </option>
                                <option value="system" {{ request('type') === 'system' ? 'selected' : '' }}>System
                                </option>
                            </select>
                        </div>
                        <div>
                            <select name="user_id" class="border-gray-300 rounded-md shadow-sm text-sm">
                                <option value="">All Users</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2 px-4 rounded">
                            Filter
                        </button>
                    </form>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table
                            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border-collapse border border-gray-200 dark:border-gray-700">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th
                                        class="p-4 text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200 dark:border-gray-600">
                                        User</th>
                                    <th
                                        class="p-4 text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200 dark:border-gray-600">
                                        Type</th>
                                    <th
                                        class="p-4 text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200 dark:border-gray-600">
                                        Message</th>
                                    <th
                                        class="p-4 text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200 dark:border-gray-600">
                                        Status</th>
                                    <th
                                        class="p-4 text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200 dark:border-gray-600">
                                        Expiration</th>
                                    <th
                                        class="p-4 text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200 dark:border-gray-600">
                                        Created</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($notifications as $notification)
                                    <tr class="hover:bg-gray-50">
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border border-gray-200 dark:border-gray-700">
                                            {{ $notification->user ? $notification->user->name : 'All Users' }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border border-gray-200 dark:border-gray-700">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $notification->type === 'marketing' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $notification->type === 'invoices' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $notification->type === 'system' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($notification->type) }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate border border-gray-200 dark:border-gray-700">
                                            {{ $notification->short_text }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border border-gray-200 dark:border-gray-700">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $notification->is_read ? 'bg-green-200 text-green-700' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $notification->is_read ? 'Read' : 'Unread' }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border border-gray-200 dark:border-gray-700">
                                            {{ $notification->expiration->format('M d, Y') }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border border-gray-200 dark:border-gray-700">
                                            {{ $notification->created_at->format('M d, Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
