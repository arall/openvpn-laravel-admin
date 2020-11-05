<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        User list
    </h2>
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
                Online
                <input type="checkbox" wire:model="isOnline" value="1">
            </div>
        </div>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
        <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
            <thead>
                <tr class="text-left">
                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">ID</th>
                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">Name</th>
                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">Role</th>
                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">Email</th>
                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">Status</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="border-dashed border-t border-gray-200">
                        <span class="text-gray-700 px-6 py-3 flex items-center">{{ $user->id }}</span>
                    </td>
                    <td class="border-dashed border-t border-gray-200">
                        <span class="text-gray-700 px-6 py-3 flex items-center">
                            <img class="h-8 w-8 rounded-full object-cover mr-3" src="{{ $user->google_photo_url }}">
                            {{ $user->name }}
                        </span>
                    </td>
                    <td class="border-dashed border-t border-gray-200">
                        <span class="text-gray-700 px-6 py-3 flex items-center">
                            @if($user->is_admin)
                                Admin
                            @else
                                User
                            @endif
                        </span>
                    </td>
                    <td class="border-dashed border-t border-gray-200">
                        <span class="text-gray-700 px-6 py-3 flex items-center">{{ $user->email }}</span>
                    </td>
                    <td class="border-dashed border-t border-gray-200">
                        <span class="text-gray-700 px-6 py-3 flex items-center">
                            @if($user->is_online)
                                <span class="inline-block rounded-full w-2 h-2 mr-2 bg-green-500"></span>
                                Online
                            @else
                                <span class="inline-block rounded-full w-2 h-2 mr-2 bg-red-500"></span>
                                Offline
                            @endif
                        </span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mb-4 flex justify-between items-center mt-4">
        <div class="flex-1 pr-4">
            {{ $users->links() }}
        </div>
    </div>

</div>