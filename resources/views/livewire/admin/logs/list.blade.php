<x-slot name="header">
    <div class="grid grid-cols-3 gap-4">
        <div class="col-span-2">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
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

<div class="container px-4 py-6 mx-auto">
    <div class="flex items-center justify-between mb-4">
        <div class="flex-1 pr-4">
            <div class="relative md:w-2/3">
                <input type="search"
                       class="w-full py-2 pl-10 pr-4 font-medium text-gray-600 rounded-lg shadow focus:outline-none focus:shadow-outline"
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
        <div class="flex-1 pr-4">
            <div class="relative md:w-2/3">
                <input type="search"
                       class="w-full py-2 pl-10 pr-4 font-medium text-gray-600 rounded-lg shadow focus:outline-none focus:shadow-outline"
                       wire:model="date"
                       placeholder="YYY-MM-DD">
            </div>
        </div>
        <div>
            <div class="mr-4">
                Active
                <input type="checkbox" wire:model="isActive" value="1">
            </div>
        </div>
    </div>

    <div class="relative overflow-x-auto overflow-y-auto bg-white rounded-lg shadow">
        <table class="relative w-full whitespace-no-wrap bg-white border-collapse table-auto table-striped">
            <thead>
            <tr class="text-left">
                <x-table.sortable :direction="$sortField === 'id' ? $sortDirection : null">ID</x-table.sortable>
                <x-table.sortable :direction="$sortField === 'user_id' ? $sortDirection : null" :field="'user_id'">User</x-table.sortable>
                <th class="sticky top-0 px-6 py-2 text-xs font-bold tracking-wider text-gray-600 uppercase bg-gray-100 border-b border-gray-200">Client IP</th>
                <th class="sticky top-0 px-6 py-2 text-xs font-bold tracking-wider text-gray-600 uppercase bg-gray-100 border-b border-gray-200">Location</th>
                <x-table.sortable :direction="$sortField === 'remote_ip' ? $sortDirection : null">Remote IP</x-table.sortable>
                <x-table.sortable :direction="$sortField === 'bytes_received' ? $sortDirection : null">Bytes Received</x-table.sortable>
                <x-table.sortable :direction="$sortField === 'end_time' ? $sortDirection : null">End Time</x-table.sortable>
            </tr>
            </thead>
            <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td class="border-t border-gray-200 border-dashed">
                        <span class="flex items-center px-6 py-3 text-gray-700">{{ $log->id }}</span>
                    </td>
                    <td class="border-t border-gray-200 border-dashed">
                        <span class="flex items-center px-6 py-3 text-gray-700">
                            <img class="object-cover w-8 h-8 mr-3 rounded-full" src="{{ $log->user->google_photo_url }}">
                            {{ $log->user->name }}
                        </span>
                    </td>
                    <td class="border-t border-gray-200 border-dashed">
                        <span class="flex items-center px-6 py-3 text-gray-700">{{ $log->client_ip }}</span>
                    </td>
                    <td class="border-t border-gray-200 border-dashed">
                        <span class="flex items-center px-6 py-3 text-gray-700">{{ $log->client_location }}</span>
                    </td>
                    <td class="border-t border-gray-200 border-dashed">
                        <span class="flex items-center px-6 py-3 text-gray-700">{{ $log->remote_ip }}</span>
                    </td>
                    <td class="border-t border-gray-200 border-dashed">
                        <span class="flex items-center px-6 py-3 text-gray-700">{{ $log->start_time }}</span>
                    </td>
                    <td class="border-t border-gray-200 border-dashed">
                        <span class="flex items-center px-6 py-3 text-gray-700">{{ $log->end_time }}</span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="flex items-center justify-between mt-4 mb-4">
        <div class="flex-1 pr-4">
            {{ $logs->links() }}
        </div>
    </div>

</div>
