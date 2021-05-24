<x-slot name="header">
    <div class="grid grid-cols-3 gap-4">
        <div class="col-span-2">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Logs
            </h2>
        </div>
        <div class="col-span-1 text-right">
            Total: {{ $total }} |
            <span class="text-green-500">Active: {{ $active }} </span> |
            <span class="text-red-500">Inactive: {{ $inactive }} </span>
        </div>
    </div>
</x-slot>

<div class="container mx-auto py-6 px-4">
    <div class="mb-4 flex justify-between items-center">
        <div class="flex-1 pr-4">
            <div class="relative md:w-1/3">
                <input type="search"
                       class="w-full pl-10 pr-4 py-2 rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium"
                       wire:model="search"
                       placeholder="Search...">
                <div class="absolute top-0 left-0 inline-flex items-center p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                        <circle cx="10" cy="10" r="7" />
                        <line x1="21" y1="21" x2="15" y2="15" />
                    </svg>
                </div>
            </div>
        </div>
        <div>
            <div class="mr-4">
                Active
                <input type="checkbox" wire:model="isActive" value="1">
            </div>
        </div>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
        <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
            <thead>
            <tr class="text-left">
                <x-table.sortable :direction="$sortField === 'id' ? $sortDirection : null">ID</x-table.sortable>
                <x-table.sortable :direction="$sortField === 'user_id' ? $sortDirection : null" :field="'user_id'">User</x-table.sortable>
                <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">Client IP</th>
                <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">Location</th>
                <x-table.sortable :direction="$sortField === 'remote_ip' ? $sortDirection : null">Remote IP</x-table.sortable>
                <x-table.sortable :direction="$sortField === 'bytes_received' ? $sortDirection : null">Bytes Received</x-table.sortable>
                <x-table.sortable :direction="$sortField === 'bytes_sent' ? $sortDirection : null">Bytes Sent</x-table.sortable>
                <x-table.sortable :direction="$sortField === 'start_time' ? $sortDirection : null">Start Time</x-table.sortable>
                <x-table.sortable :direction="$sortField === 'end_time' ? $sortDirection : null">End Time</x-table.sortable>
            </tr>
            </thead>
            <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td class="border-dashed border-t border-gray-200">
                        <span class="text-gray-700 px-6 py-3 flex items-center">{{ $log->id }}</span>
                    </td>
                    <td class="border-dashed border-t border-gray-200">
                        <span class="text-gray-700 px-6 py-3 flex items-center">
                            <img class="h-8 w-8 rounded-full object-cover mr-3" src="{{ $log->user->google_photo_url }}">
                            {{ $log->user->name }}
                        </span>
                    </td>
                    <td class="border-dashed border-t border-gray-200">
                        <span class="text-gray-700 px-6 py-3 flex items-center">{{ $log->client_ip }}</span>
                    </td>
                    <td class="border-dashed border-t border-gray-200">
                        <span class="text-gray-700 px-6 py-3 flex items-center">{{ $log->client_location }}</span>
                    </td>
                    <td class="border-dashed border-t border-gray-200">
                        <span class="text-gray-700 px-6 py-3 flex items-center">{{ $log->remote_ip }}</span>
                    </td>
                    <td class="border-dashed border-t border-gray-200">
                        <span class="text-gray-700 px-6 py-3 flex items-center">{{ $log->bytes_received }}</span>
                    </td>
                    <td class="border-dashed border-t border-gray-200">
                        <span class="text-gray-700 px-6 py-3 flex items-center">{{ $log->bytes_sent }}</span>
                    </td>
                    <td class="border-dashed border-t border-gray-200">
                        <span class="text-gray-700 px-6 py-3 flex items-center">{{ $log->start_time }}</span>
                    </td>
                    <td class="border-dashed border-t border-gray-200">
                        <span class="text-gray-700 px-6 py-3 flex items-center">{{ $log->end_time }}</span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mb-4 flex justify-between items-center mt-4">
        <div class="flex-1 pr-4">
            {{ $logs->links() }}
        </div>
    </div>

</div>